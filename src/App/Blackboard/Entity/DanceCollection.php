<?php


namespace src\App\Blackboard\Entity;

class DanceCollection
{
    private $danceArray = [];

    public function add(DanceEntity $entity)
    {
        $this->danceArray[] = $entity;
    }

    /**
     * @return DanceEntity[]
     */
    public function getDanceArray()
    {
        return $this->danceArray;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->danceArray as $dance) {
            /** @var DanceEntity $dance */
            $result[] = [
                $dance->toArray()
            ];
        }
        
        return $result;
    }
}