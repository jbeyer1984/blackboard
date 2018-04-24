<?php


namespace src\App\Blackboard\Entity;

use src\Core\Entity\ToArrayInterface;

class PersonEntity implements ToArrayInterface
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
     * PersonEntity constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @param int $id
//     * @return PersonEntity
//     */
//    public function setId($id)
//    {
//        $this->id = $id;
//
//        return $this;
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PersonEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}