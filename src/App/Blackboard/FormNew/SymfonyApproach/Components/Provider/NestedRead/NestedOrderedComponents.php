<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\NestedRead;


use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderCollection;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Utility\NamespaceHelper;

class NestedOrderedComponents
{
    /**
     * @var Builder
     */
    private $builder;
    
    /** @var mixed */
    private $components = [];

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
        $this->components = [];
        return $this->getEntriesMapLoop($namespace, $this->builder->getEntriesOrdered());
    }

    /**
     * @param string $namespaceToSearch
     * @param array $map
     * @return mixed
     */
    protected function getEntriesMapLoop($namespaceToSearch, $map)
    {
        foreach ($map as $entryIndex => $entry) {
            if ($entry instanceof Builder) {
                $this->getEntriesMapLoop($namespaceToSearch, $entry->getEntriesOrdered());
            } elseif ($entry instanceof BuilderCollection) {
                foreach ($entry->getBuilderCollection() as $builder) {
                    $this->getEntriesMapLoop($namespaceToSearch, $builder->getEntriesOrdered());
                }
            } else {
                $namespace = $entry->getIdentifier();
                $inNamespace = NamespaceHelper::getDeterminedNamespaceComparison($namespaceToSearch, $namespace);
                if ($inNamespace) {
                    $this->components[] = $entry;
                }
            }
        }

        return $this->components;
    }
}