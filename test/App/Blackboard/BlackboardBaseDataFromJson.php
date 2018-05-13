<?php


namespace test\App\Blackboard;


use src\App\Blackboard\Configuration\EntryFile;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntityCollection;


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