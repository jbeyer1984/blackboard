<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components;


use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Option\RenderOption;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\RenderWrapperComponentInterface;

class Div implements RenderWrapperComponentInterface
{
    /**
     * @var string
     */
    private $identifier;
    
    /**
     * @var RenderOption
     */
    private $option;

    /**
     * Area constructor.
     * @param $identifier
     * @param RenderOption $option
     */
    public function __construct($identifier, RenderOption $option)
    {
        $this->identifier = $identifier;
        $this->option     = $option;
    }

    /**
     * @return string
     */
    public function renderStart()
    {
        $html = <<<TXT
<div>
TXT;
        
        return $html . PHP_EOL;
    }

    /**
     * @return string
     */
    public function renderEnd()
    {
        $html = <<<TXT
</div>
TXT;

        return $html . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return RenderOption
     */
    public function getOption()
    {
        return $this->option;
    }
}