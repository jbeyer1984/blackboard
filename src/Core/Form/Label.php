<?php


namespace src\Core\Form;


class Label
{
    /**
     * @var string
     */
    private $value;

    /**
     * Label constructor.
     * @param string $label
     */
    public function __construct($label)
    {
        $this->value = $label;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}