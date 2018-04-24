<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components;


class LabelTextOnly
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
     * Label constructor.
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
<label for="{$this->identifier}">{$this->value}: </label>
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
}