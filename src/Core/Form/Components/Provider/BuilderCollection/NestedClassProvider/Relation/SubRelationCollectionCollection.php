<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation;


use src\Core\Entity\CollectionInterface;

class SubRelationCollectionCollection implements CollectionInterface
{
    /**
     * @var SubRelationCollection[]
     */
    private $collection;

    public function add(SubRelationCollection $relation)
    {
        $this->collection[] = $relation;
    }

    /**
     * @return SubRelationCollection[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}