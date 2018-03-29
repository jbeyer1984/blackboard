<?php


namespace src\App\Blackboard\Form\Collection;


use src\App\Blackboard\Form\Components\DanceForm;

class DanceFormCollection
{
    /**
     * @var DanceForm[]
     */
    private $danceFormArray = [];

    /**
     * @param DanceForm $form
     */
    public function add(DanceForm $form)
    {
        $this->danceFormArray[] = $form;
    }

    /**
     * @return DanceForm[]
     */
    public function getDanceFormArray()
    {
        return $this->danceFormArray;
    }
}