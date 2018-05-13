<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity;

use src\Core\Entity\CollectionInterface;
use src\Core\Entity\ToArrayInterface;

class DanceEntityCollection implements ToArrayInterface, CollectionInterface
{
    /**
     * @var DanceEntity[]
     */
    private $collection = [];

    public function add(DanceEntity $entity)
    {
        $this->collection[] = $entity;
    }

    /**
     * @return DanceEntity[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    public function remove(DanceEntity $entity)
    {
        foreach ($this->collection as $index => $danceEntity) {
            if ($danceEntity->getId() == $entity->getId()) {
                unset($this->collection[$index]);
            }
        }
    }

    public function clear()
    {
        $this->collection = [];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->collection as $dance) {
            /** @var DanceEntity $dance */
            $result[] = [
                $dance->toArray()
            ];
        }
        
        return $result;
    }
}