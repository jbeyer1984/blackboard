<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity;


use src\Core\Entity\ToArrayInterface;

class DanceEntity implements ToArrayInterface
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var ExperienceEntityCollection
     */
    private $experienceEntityCollection;

    /**
     * DanceEntity constructor.
     * @param $id
     * @param string $dance
     * @param ExperienceEntityCollection $experienceEntityCollection
     */
    public function __construct($id, $dance, ExperienceEntityCollection $experienceEntityCollection)
    {
        $this->id                         = $id;
        $this->name                       = $dance;
        $this->experienceEntityCollection = $experienceEntityCollection;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return DanceEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ExperienceEntityCollection
     */
    public function getExperienceEntityCollection()
    {
        return $this->experienceEntityCollection;
    }

    /**
     * @param ExperienceEntityCollection $experienceEntityCollection
     * @return DanceEntity
     */
    public function setExperienceEntityCollection($experienceEntityCollection)
    {
        $this->experienceEntityCollection = $experienceEntityCollection;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'experience' => $this->experienceEntityCollection
        ];
    }
}