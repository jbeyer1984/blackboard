<?php

namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Choice;

class SelectBox
{
    /**
     * @var string
     */
    private $identifier;
    
    /**
     * @var SelectBoxOptionCollection
     */
    private $selectBoxOptionCollection;

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
        $this->init();
    }

    protected function init()
    {
        $this->selectBoxOptionCollection = new SelectBoxOptionCollection();
    }

    public function addOption(SelectBoxOption $selectBoxOption)
    {
        $this->selectBoxOptionCollection->add($selectBoxOption);
    }

    /**
     * @return string
     */
    public function render()
    {
        $html = '';
        
        if (0 < count($this->selectBoxOptionCollection->getCollection())) {
            $html = <<<TXT
<select name="{$this->identifier}">
TXT;
            $html .= PHP_EOL;
            foreach ($this->selectBoxOptionCollection->getCollection() as $selectBoxOption) {
                /** @var SelectBoxOption $selectBoxOption */
                $checked = '';
                if ($selectBoxOption->isOn()) {
                    $checked = 'selected';
                }
                $html .= <<<TXT
<option value="{$selectBoxOption->getValue()}" {$checked}>
{$selectBoxOption->getValueToDisplay()}
</option>

TXT;

            }
            $html .= <<<TXT
</select>
TXT;

            
        }
        
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
     * @return SelectBoxOptionCollection
     */
    public function getSelectBoxOptionCollection()
    {
        return $this->selectBoxOptionCollection;
    }
}