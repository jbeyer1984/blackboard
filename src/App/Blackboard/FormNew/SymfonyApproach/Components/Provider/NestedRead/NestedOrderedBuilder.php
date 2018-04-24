<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\NestedRead;


use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderCollection;

class NestedOrderedBuilder
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
     * @return Builder[]
     */
    public function getBuilderNestedByNamespace($namespace)
    {
        return $this->getBuilderMapLoopRendered($namespace, $this->builder->getEntriesOrdered());
    }

    /**
     * @param string $namespaceToSearch
     * @param $map
     * @return Builder[]
     */
    protected function getBuilderMapLoopRendered($namespaceToSearch, $map)
    {
        $builders = [];
        foreach ($map as $index => $entry) {
            if ($entry instanceof BuilderCollection) {
                if ($namespaceToSearch == $entry->getNamespace()) {
                    $builders[] = $entry;
                }
            }
        }

        return $builders;
    }
}