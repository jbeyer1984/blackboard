<?php


namespace src\Core\Form\Components\Render\Components\Collection;


use src\Core\Form\Components\Render\Components\TypeWrapper;

class TypeWrapperCollection
{
    /**
     * @var TypeWrapper[]
     */
    private $collection;

    public function add(TypeWrapper $wrapper)
    {
        $this->collection[] = $wrapper;
    }

    /**
     * @return TypeWrapper[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}