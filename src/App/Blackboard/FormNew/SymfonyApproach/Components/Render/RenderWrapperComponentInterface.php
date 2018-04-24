<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Render;


use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Option\RenderOption;

interface RenderWrapperComponentInterface
{
    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return RenderOption
     */
    public function getOption();
    
    /**
     * @return string
     */
    public function renderStart();

    /**
     * @return string
     */
    public function renderEnd();
}