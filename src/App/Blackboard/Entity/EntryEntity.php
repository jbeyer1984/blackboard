<?php


namespace src\App\Blackboard\Entity;

class EntryEntity
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
     * @var PersonalEntity
     */
    private $personal;

    /**
     * @var DanceCollection
     */
    private $danceCollection;

    /**
     * EntryEntity constructor.
     * @param int $id
     * @param string $time
     * @param PersonalEntity $personal
     * @param DanceCollection $danceCollection
     */
    public function __construct($id, $time, PersonalEntity $personal, DanceCollection $danceCollection)
    {
        $this->id              = $id;
        $this->time            = $time;
        $this->personal        = $personal;
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
     * @return PersonalEntity
     */
    public function getPersonal()
    {
        return $this->personal;
    }

    /**
     * @return DanceCollection
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
            'personal' => $this->personal->toArray(),
            'dance' => $this->danceCollection->toArray(),
        ];
    }
}