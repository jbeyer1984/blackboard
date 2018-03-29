<?php


namespace src\App\Blackboard\Form\Components;

use src\Core\Form\CheckBox;
use src\Core\Form\SelectBox;

class DanceForm
{
    /**
     * @var Checkbox
     */
    private $danceType;

    /**
     * @var SelectBox
     */
    private $dance;

    /**
     * DanceForm constructor.
     * @param CheckBox $danceType
     * @param SelectBox $dance
     */
    public function __construct(CheckBox $danceType, SelectBox $dance)
    {
        $this->danceType = $danceType;
        $this->dance     = $dance;
    }

    /**
     * @return CheckBox
     */
    public function getDanceType()
    {
        return $this->danceType;
    }

    /**
     * @return SelectBox
     */
    public function getDance()
    {
        return $this->dance;
    }
}