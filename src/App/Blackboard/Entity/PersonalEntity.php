<?php


namespace src\App\Blackboard\Entity;


class PersonalEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * PersonalEntity constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name
        ];
    }
}