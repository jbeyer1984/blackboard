<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity;

use src\Core\Entity\ToArrayInterface;

class EntryEntity implements ToArrayInterface
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $time;
    
    /**
     * @var PersonEntity
     */
    private $person;

    /**
     * @var DanceEntityCollection
     */
    private $danceCollection;

    /**
     * EntryEntity constructor.
     * @param int $id
     * @param string $time
     * @param PersonEntity $personal
     * @param DanceEntityCollection $danceCollection
     */
    public function __construct($id, $time, PersonEntity $personal, DanceEntityCollection $danceCollection)
    {
        $this->id              = $id;
        $this->time            = $time;
        $this->person          = $personal;
        $this->danceCollection = $danceCollection;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return PersonEntity
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @return DanceEntityCollection
     */
    public function getDanceCollection()
    {
        return $this->danceCollection;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'time' => $this->time,
            'personal' => $this->person->toArray(),
            'dance' => $this->danceCollection->toArray(),
        ];
    }
}