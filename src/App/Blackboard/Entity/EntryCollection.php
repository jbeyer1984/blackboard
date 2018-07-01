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

    public function sortReverse()
    {
        uasort($this->collection, function ($row, $row2) {
            /** @var EntryEntity $row */
            /** @var EntryEntity $row2 */
            if ($row->getId() == $row2->getId()) {
                return 0;
            }

            return ($row->getId() > $row2->getId()) ? -1 : 1;
        });
        
        return $this;
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