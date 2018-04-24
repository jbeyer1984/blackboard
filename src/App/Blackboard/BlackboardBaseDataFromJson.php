<?php

namespace src\App\Blackboard;

use src\App\Blackboard\Configuration\EntryFile;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\DanceEntityCollection;
use src\App\Blackboard\Entity\ExperienceEntity;
use src\App\Blackboard\Entity\ExperienceEntityCollection;

class BlackboardBaseDataFromJson
{
    /**
     * @var EntryFile
     */
    private $entryFile;
    
    private $data;

    /**
     * BlackboardData constructor.
     * @param EntryFile $entryFile
     */
    public function __construct(EntryFile $entryFile)
    {
        $this->entryFile = $entryFile;
        
        $this->init();
    }

    protected function init()
    {
        $this->data = $this->entryFile->readData();
    }

    /**
     * @return DanceEntityCollection
     */
    public function getDanceEntityCollection()
    {
        $danceEntityCollection = new DanceEntityCollection();
        foreach ($this->data['dance'] as $entry) {
            $danceEntityCollection->add(new DanceEntity($entry['id'], $entry['name'], new ExperienceEntityCollection()));
        }
        
        return $danceEntityCollection;
    }

    /**
     * @return ExperienceEntityCollection
     */
    public function getExperienceEntityCollection()
    {
        $experienceEntityCollection = new ExperienceEntityCollection();
        foreach ($this->data['experience'] as $entry) {
            $experienceEntityCollection->add(new ExperienceEntity($entry['id'], $entry['name']));
        }

        return $experienceEntityCollection;
    }
}