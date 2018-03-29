<?php


namespace src\App\Blackboard\Entity;


class EntryCollection
{
    /**
     * @var array EntryEntity[]
     */
    private $entryArray = [];

    public function add(EntryEntity $entity)
    {
        $this->entryArray[] = $entity;
    }

    /**
     * @return EntryEntity[]
     */
    public function getEntryArray()
    {
        return $this->entryArray;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->entryArray as $entry) {
            /** @var EntryEntity $entry */
            $result[] = $entry->toArray();
        }
        
        return $result;
    }
}