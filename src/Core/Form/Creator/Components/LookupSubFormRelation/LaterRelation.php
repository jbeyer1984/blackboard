<?php


namespace src\Core\Form\Creator\Components\LookupSubFormRelation;


use src\Core\Form\NestedBuilderRelation;

class LaterRelation
{
    /**
     * @var NestedBuilderRelation
     */
    private $nestedRelation;

    /**
     * @var mixed
     */
    private $data;

    /**
     * LaterRelation constructor.
     * @param NestedBuilderRelation $nestedRelation
     * @param mixed $data
     */
    public function __construct(NestedBuilderRelation $nestedRelation, $data)
    {
        $this->nestedRelation = $nestedRelation;
        $this->data           = $data;
    }

    /**
     * @return NestedBuilderRelation
     */
    public function getNestedRelation()
    {
        return $this->nestedRelation;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


}