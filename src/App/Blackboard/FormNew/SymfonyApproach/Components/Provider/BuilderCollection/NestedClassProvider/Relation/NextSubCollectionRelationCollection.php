<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\BuilderCollection\NestedClassProvider\Relation;


use src\Core\Entity\CollectionInterface;

class NextSubCollectionRelationCollection implements CollectionInterface
{
    /**
     * @var SubCollectionRelation[]
     */
    private $collection;

    public function add(SubCollectionRelation $relation)
    {
        $this->collection[] = $relation;
    }

    /**
     * @return SubCollectionRelation[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}