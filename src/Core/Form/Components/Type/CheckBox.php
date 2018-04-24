<?php


namespace src\Core\Form\Components\Type;


class CheckBox
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
    private $isOn;

    /**
     * CheckBox constructor.
     * @param string $identifier
     * @param string $value
     * @param bool $isOn
     */
    public function __construct($identifier, $value, $isOn)
    {
        $this->identifier = $identifier;
        $this->value      = $value;
        $this->isOn       = $isOn;
    }

    /**
     * @return string
     */
    public function render()
    {
        $checked = '';
        if ($this->isOn) {
            $checked = 'checked';
        }
        $html = <<<TXT
<input type="checkbox" name="{$this->identifier}" value="{$this->value}" {$checked}/>
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
     * @return bool
     */
    public function isOn()
    {
        return $this->isOn;
    }
}