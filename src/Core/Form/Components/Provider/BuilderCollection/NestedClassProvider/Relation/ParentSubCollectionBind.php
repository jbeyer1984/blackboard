<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation;


use src\Core\Entity\CollectionInterface;

class ParentSubCollectionBind
{
    /**
     * @var array
     */
    private $postRelevant;
    
    /**
     * @var CollectionInterface
     */
    private $parentCollection;

    /**
     * @var NextSubCollectionRelationCollection
     */
    private $subCollectionRelationCollection;

    /**
     * ParentSubCollectionBind constructor.
     * @param array $addAttributes
     * @param CollectionInterface $parentCollection
     * @param NextSubCollectionRelationCollection $subCollectionRelationCollection
     */
    public function __construct(array $addAttributes, CollectionInterface $parentCollection, NextSubCollectionRelationCollection $subCollectionRelationCollection)
    {
        $this->postRelevant                    = $addAttributes;
        $this->parentCollection                = $parentCollection;
        $this->subCollectionRelationCollection = $subCollectionRelationCollection;
    }

    /**
     * @return array
     */
    public function getPostRelevant()
    {
        return $this->postRelevant;
    }

    /**
     * @return CollectionInterface
     */
    public function getParentCollection()
    {
        return $this->parentCollection;
    }

    /**
     * @return NextSubCollectionRelationCollection
     */
    public function getSubCollectionRelationCollection()
    {
        return $this->subCollectionRelationCollection;
    }
}