<?php


namespace src\App\Blackboard\Form;


use src\App\Blackboard\Form\Collection\DanceFormCollection;
use src\Core\Form\TextField;

class EntryForm
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
     * @var TextField
     */
    private $personal;

    /**
     * @var  DanceFormCollection
     */
    private $danceFormCollection;

    /**
     * EntryForm constructor.
     * @param int $id
     * @param string $time
     * @param TextField $personal
     * @param DanceFormCollection $danceFormCollection
     */
    public function __construct($id, $time, TextField $personal, DanceFormCollection $danceFormCollection)
    {
        $this->id                  = $id;
        $this->time                = $time;
        $this->personal            = $personal;
        $this->danceFormCollection = $danceFormCollection;
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
     * @return TextField
     */
    public function getPersonal()
    {
        return $this->personal;
    }

    /**
     * @return DanceFormCollection
     */
    public function getDanceFormCollection()
    {
        return $this->danceFormCollection;
    }
}