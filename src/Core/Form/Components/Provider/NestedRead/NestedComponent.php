<?php


namespace src\Core\Form\Components\Provider\NestedRead;


use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;

class NestedComponent
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
    public function getNestedComponentByNamespace($namespace)
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
        $component = null;
        foreach ($map as $namespace => $entry) {
            
            if ($entry instanceof BuilderCollection) {
                foreach ($entry->getBuilderCollection() as $builder) {
                    $component = $this->getEntriesMapLoop($namespaceToSearch, $builder->getEntriesMap());
                    if (!is_null($component)) {
                        break;
                    }
                }
            } elseif ($namespaceToSearch === $namespace) {
                $component = $entry;
                break;
            }
        }

        return $component;
    }
}