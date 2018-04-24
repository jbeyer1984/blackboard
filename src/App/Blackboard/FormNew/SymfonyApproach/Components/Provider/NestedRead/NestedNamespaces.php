<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\NestedRead;


use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderCollection;

class NestedNamespaces
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
     * @return array
     */
    public function getEntriesMapNested()
    {
        return $this->getEntriesMapLoop($this->builder->getEntriesMap());
    }

    /**
     * @param $map
     * @return array
     */
    protected function getEntriesMapLoop($map)
    {
        $mapAdded = [];
        foreach ($map as $namespace => $entry) {
            if ($entry instanceof BuilderCollection) {
                foreach ($entry->getBuilderCollection() as $builder) {
                    $mapAdded[] = $this->getEntriesMapLoop($builder->getEntriesMap());
                }
            } else {
                $mapAdded[] = $namespace;
            }
        }

        return $mapAdded;
    }
}