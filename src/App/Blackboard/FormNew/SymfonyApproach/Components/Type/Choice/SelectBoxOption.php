<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Choice;


class SelectBoxOption
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
     * @var string
     */
    private $valueToDisplay;

    /**
     * @var bool
     */
    private $on;

    /**
     * SelectBoxOption constructor.
     * @param string $identifier
     * @param string $value
     * @param string $valueToDisplay
     */
    public function __construct($identifier, $value, $valueToDisplay)
    {
        $this->identifier     = $identifier;
        $this->value          = $value;
        $this->valueToDisplay = $valueToDisplay;
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
     * @return string
     */
    public function getValueToDisplay()
    {
        return $this->valueToDisplay;
    }

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->on;
    }

    /**
     * @param bool $on
     * @return SelectBoxOption
     */
    public function setOn($on)
    {
        $this->on = $on;

        return $this;
    }
}