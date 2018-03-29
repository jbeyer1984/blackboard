<?php


namespace src\Core\Form;


class SelectBox
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var SelectOptionCollection
     */
    private $optionCollection;

    /**
     * Checkbox constructor.
     * @param string $label
     * @param SelectOptionCollection $optionCollection
     */
    public function __construct($label, SelectOptionCollection $optionCollection)
    {
        $this->label            = $label;
        $this->optionCollection = $optionCollection;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return SelectOptionCollection
     */
    public function getOptionCollection()
    {
        return $this->optionCollection;
    }
}