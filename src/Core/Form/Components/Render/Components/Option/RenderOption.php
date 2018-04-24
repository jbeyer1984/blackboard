<?php


namespace src\Core\Form\Components\Render\Components\Option;


use src\Core\Form\Components\Render\Components\Option\Variant\RenderAttributes;

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