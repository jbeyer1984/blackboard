<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\NestedRead;


use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderCollection;

class NestedComponents
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * NestedNamespaces constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param string $namespace
     * @return array
     */
    public function getNestedComponentsByNamespace($namespace)
    {
        return $this->getEntriesMapLoop($namespace, $this->builder->getEntriesMap());
    }

    /**
     * @param string $namespaceToSearch
     * @param array $map
     * @return mixed
     */
    protected function getEntriesMapLoop($namespaceToSearch, $map)
    {
        $components = [];
        foreach ($map as $namespace => $entry) {
            
            if ($entry instanceof BuilderCollection) {
                foreach ($entry->getBuilderCollection() as $builder) {
                    $value = $this->getEntriesMapLoop($namespaceToSearch, $builder->getEntriesMap());
                    if (!empty($value)) {
                        $components[] = $value;
                    }
                }
            } else {
                $explodedToSearchUntilHash = explode('#', $namespaceToSearch);
                $namespaceToCut = $namespace;
                $restFields = [];
                foreach ($explodedToSearchUntilHash as $index => $withoutHash) {
                    if (false !== stripos($namespaceToCut, $withoutHash)) {
                        $strPos = stripos($namespaceToCut, $withoutHash);
                        if (isset($explodedToSearchUntilHash[$index + 1])) {
                            $justCheck = substr($namespaceToCut, $strPos + strlen($withoutHash));
                            $lookAheadWithoutHash = $explodedToSearchUntilHash[$index + 1];
                            $justCheckLooAheadPos = stripos($justCheck, $lookAheadWithoutHash);
                            $restFields[] = substr(
                                $namespaceToCut,
                                $strPos + strlen($withoutHash),
                                $justCheckLooAheadPos
                            );
                            $namespaceToCut = substr(
                                $namespaceToCut,
                                $strPos + strlen($withoutHash) + $justCheckLooAheadPos
                            );
                        } else {
                            $namespaceToCut = str_replace($withoutHash, '', $namespaceToCut);
                        }
                            
                    }
                }
                if (false === stripos($namespaceToCut, '[') && false === stripos($namespaceToCut, ']')) {
                    $components[] = $entry;
                }
            }
        }

        return $components;
    }
}