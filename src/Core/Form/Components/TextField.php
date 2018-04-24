<?php


namespace src\Core\Form\Components;


class TextField
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
     * InputHidden constructor.
     * @param string $identifier
     * @param string $value
     */
    public function __construct($identifier, $value)
    {
        $this->identifier = $identifier;
        $this->value      = $value;
    }

    /**
     * @return string
     */
    public function render()
    {
        $html = <<<TXT
<input type="text" name="{$this->identifier}" value="{$this->value}"/>
TXT;

        return $html;
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
     * @param string $value
     * @return TextField
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}