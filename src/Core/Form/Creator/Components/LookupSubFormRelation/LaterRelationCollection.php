<?php


namespace src\Core\Form\Creator\Components\LookupSubFormRelation;


use src\Core\Entity\CollectionInterface;

class LaterRelationCollection implements CollectionInterface
{
    /**
     * @var LaterRelation[]
     */
    private $collection = [];

    /**
     * @param $identifier
     * @return bool
     */
    public function has($identifier)
    {
        $existing = isset($this->collection[$identifier]);
            
        return $existing;
    }

    /**
     * @param $identifier
     * @return LaterRelation
     */
    public function get($identifier)
    {
        $this->identifierIndexNotInCollectionException($identifier);

        return $this->collection[$identifier];
    }

    /**
     * @param string $identifier
     * @param LaterRelation $laterRelation
     */
    public function add($identifier, LaterRelation $laterRelation)
    {
        $this->indexAlreadyExistException($identifier); // @todo uncomment
        $this->collection[$identifier] = $laterRelation;
    }

    /**
     * @param string $identifier
     */
    public function remove($identifier)
    {
        $this->canNotRemoveNonExistingEntryException($identifier);
        unset($this->collection[$identifier]);
    }

    /**
     * @return LaterRelation[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param $identifier
     * @throws \Exception
     */
    private function indexAlreadyExistException($identifier)
    {
        if (isset($this->collection[$identifier])) {
            throw new \Exception("there is an overwrite same index: {$identifier} already exists");
        }
    }

    /**
     * @param $identifier
     * @throws \Exception
     */
    private function canNotRemoveNonExistingEntryException($identifier)
    {
        if (!isset($this->collection[$identifier])) {
            throw new \Exception("there is no entry: {$identifier} to remove");
        }
    }

    /**
     * @param $identifier
     * @throws \Exception
     */
    private function identifierIndexNotInCollectionException($identifier)
    {
        if (!$this->has($identifier)) {
            throw new \Exception("identifier index: {$identifier} not in collection");
        }
    }
}