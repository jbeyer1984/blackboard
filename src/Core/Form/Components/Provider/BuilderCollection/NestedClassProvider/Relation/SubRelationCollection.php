<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation;

class SubRelationCollection
{
    /**
     * @var string
     */
    private $nameChain;

    /**
     * @var mixed
     */
    private $data;

    /**
     * SubCollectionRelation constructor.
     * @param $nameChain
     * @param mixed $data
     */
    public function __construct($nameChain, $data)
    {
        $this->nameChain = $nameChain;
        $this->data      = $data;
    }

    /**
     * @return string
     */
    public function getNameChain()
    {
        return $this->nameChain;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}