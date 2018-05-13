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
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $optional;

    /**
     * PersonEntity constructor.
     * @param int $id
     * @param string $name
     * @param string $number
     * @param string $optional
     */
    public function __construct($id, $name, $number, $optional)
    {
        $this->id       = $id;
        $this->name     = $name;
        $this->number   = $number;
        $this->optional = $optional;
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
     * @return PersonEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return PersonEntity
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param string $optional
     * @return PersonEntity
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;

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
            'number' => $this->number,
            'optional' => $this->optional,
        ];
    }
}