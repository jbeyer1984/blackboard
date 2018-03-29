<?php

namespace src\Core\Form;


class SelectOption
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $on;

    /**
     * SelectOption constructor.
     * @param string $identifier
     * @param string $value
     * @param bool $on
     */
    public function __construct($identifier, $value = '', $on = false)
    {
        $this->identifier = $identifier;
        $this->value      = $value;
        $this->on         = $on;
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

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->on;
    }
}