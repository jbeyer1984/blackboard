<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Option;


use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Option\Variant\RenderAttributes;

class RenderOption
{
    /**
     * @var RenderAttributes
     */
    private $attributes;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->attributes = new RenderAttributes();
    }

    /**
     * @return RenderAttributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}