<?php


namespace src\App\Blackboard\EntityNew;


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
     * @param mixed $id
     * @return DanceEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
        $experienceCollection = $this->experienceEntityCollection->toArray();
        $experienceEntries = [];
        if (isset($experienceCollection[0]) && is_array($experienceCollection[0])) {
            $experienceEntries = array_map(function($row) {
                if (isset($row[0])) {
                    return $row[0];
                }
            }, $experienceCollection);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'experience' => $experienceEntries
        ];
    }
}