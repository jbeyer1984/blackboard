<?php


namespace src\App\Blackboard\Entity;


use src\Core\Entity\CollectionInterface;
use src\Core\Entity\ToArrayInterface;

class ExperienceEntityCollection implements ToArrayInterface, CollectionInterface
{
    /**
     * @var ExperienceEntity[]
     */
    private $collection = [];

    public function add(ExperienceEntity $experience)
    {
        $this->collection[] = $experience;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->collection as $experience) {
            /** @var ExperienceEntity $experience */
            $result[] = [
                $experience->toArray()
            ];
        }

        return $result;
    }

    /**
     * @return ExperienceEntity[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}