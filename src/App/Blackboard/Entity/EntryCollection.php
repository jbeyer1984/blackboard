<?php


namespace src\App\Blackboard\Entity;


use src\Core\Entity\CollectionInterface;
use src\Core\Entity\ToArrayInterface;

class EntryCollection implements ToArrayInterface, CollectionInterface
{
    /**
     * @var array EntryEntity[]
     */
    private $collection = [];

    public function add(EntryEntity $entity)
    {
        $this->collection[] = $entity;
    }

    /**
     * @return EntryEntity[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->collection as $entry) {
            /** @var EntryEntity $entry */
            $result[] = $entry->toArray();
        }
        
        return $result;
    }
}