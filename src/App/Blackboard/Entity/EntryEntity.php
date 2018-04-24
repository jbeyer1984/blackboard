<?php


namespace src\App\Blackboard\Entity;

use src\App\Blackboard\_Blackboard;
use src\App\Blackboard\Configuration\EntryFile;
use src\Core\DI\Service;
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
     * @param PersonEntity $person
     * @param DanceEntityCollection $danceCollection
     */
    public function __construct($id, $time, PersonEntity $person, DanceEntityCollection $danceCollection)
    {
        $this->id              = $id;
        $this->time            = $time;
        $this->person          = $person;
        $this->danceCollection = $danceCollection;
    }

    /**
     * @return EntryEntity
     */
    public function createActual()
    {
        $entryFile = Service::get(_Blackboard::class)->getSingle(EntryFile::class);
        $existingData = $entryFile->readRelation();
        $lastEntry = array_pop($existingData);
        $entryId = $lastEntry['id'];
        
        $nextId = $entryId + 1;
        
        $time = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $newEntryEntity = new EntryEntity($nextId, $time, $this->person, $this->danceCollection);
        
        return $newEntryEntity;
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
        $danceCollection = $this->danceCollection->toArray();
        $danceEntries = [];
        if (isset($danceCollection[0]) && is_array($danceCollection[0])) {
            $danceEntries = array_map(function($row) {
                if (isset($row[0])) {
                    return $row[0];
                }
            }, $danceCollection);
        }
        return [
            'id' => $this->id,
            'time' => $this->time,
            'person' => $this->person->toArray(),
            'dance' => $danceEntries,
        ];
    }
}