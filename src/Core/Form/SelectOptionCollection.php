<?php


namespace src\Core\Form;


class SelectOptionCollection
{
    /**
     * @var SelectOption[]
     */
    private $optionsArray = [];

    public function add(SelectOption $option)
    {
        $this->optionsArray[] = $option;
    }

    /**
     * @return SelectOption[]
     */
    public function getOptionsArray()
    {
        return $this->optionsArray;
    }
}