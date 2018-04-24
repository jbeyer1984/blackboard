<?php


namespace src\Core\Form\Components\Provider\NestedRead;


use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;

class NestedOrderedRender
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
     * @return string
     */
    public function getEntriesNestedRendered()
    {
        return $this->getEntriesMapLoopRendered($this->builder->getEntriesOrdered());
    }

    /**
     * @param $map
     * @return string
     */
    protected function getEntriesMapLoopRendered($map)
    {
        $html = '';
        foreach ($map as $index => $entry) {
            if ($entry instanceof Builder) {
                $html .= $this->getEntriesMapLoopRendered($entry->getEntriesOrdered());
            }
            if ($entry instanceof BuilderCollection) {
                foreach ($entry->getBuilderCollection() as $builder) {
                   $html .= $this->getEntriesMapLoopRendered($builder->getEntriesOrdered());
                }
            } else {
                if (method_exists($entry, 'render')) {
                    $html .= $entry->render() . PHP_EOL;
                }
            }
        }

        return $html;
    }
}