<?php


namespace src\Core\Form;

class TextField
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $value;

    /**
     * TextField constructor.
     * @param string $label
     * @param string $identifier
     * @param string $value
     */
    public function __construct($label, $identifier, $value = null)
    {
        $this->label      = $label;
        $this->identifier = $identifier;
        $this->value      = $value;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}