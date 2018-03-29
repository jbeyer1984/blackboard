<?php


namespace src\App\Blackboard\Entity;


class DanceEntity
{
    /**
     * @var string
     */
    private $dance;

    /**
     * @var string
     */
    private $experience;

    /**
     * DanceEntity constructor.
     * @param string $dance
     * @param int $experience
     */
    public function __construct($dance, $experience)
    {
        $this->dance      = $dance;
        $this->experience = $experience;
    }

    /**
     * @return string
     */
    public function getDance()
    {
        return $this->dance;
    }

    /**
     * @return string
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'dance' => $this->dance,
            'experience' => $this->experience
        ];
    }
}