<?php


namespace src\Core\Form\Components\Render\Components\Option\Variant;


use src\Core\Entity\CollectionInterface;

class RenderAttributes implements CollectionInterface
{
    /**
     * @var array
     */
    private $collection = [];


    /**
     * @param string $attribute
     */
    public function add($attribute)
    {
        $this->collection[] = $attribute;
    }

    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }
}