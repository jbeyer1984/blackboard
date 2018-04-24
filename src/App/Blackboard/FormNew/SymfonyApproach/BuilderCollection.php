<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach;


class BuilderCollection
{
    /**
     * @var string
     */
    private $namespace;
    
    /**
     * @var Builder[] 
     */
    private $builderCollection = [];

    /**
     * BuilderCollection constructor.
     * @param string $namespace
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function add(Builder $builder)
    {
        $this->builderCollection[] = $builder;
    }

    /**
     * @return Builder[]
     */
    public function getBuilderCollection()
    {
        return $this->builderCollection;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}