<?php


namespace src\App\Login\Form;


use src\App\Login\Entity\LoginEntity;
use src\App\Login\Form\Type\LoginType;
use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Render\Components\TypeWrapper;
use src\Core\Form\Components\Render\RenderWrapper;
use src\Core\Form\Creator\FormCreator;

class LoginForm
{
    /**
     * @var FormCreator
     */
    private $formCreator;
    
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $loginEntity = new LoginEntity();
        $formCreator = new FormCreator(new LoginType(), $loginEntity);
        
        $this->formCreator = $formCreator;
    }
    /**
     * @return string
     */
    public function getRenderedForm()
    {
        $this->formCreator->build();
        $renderWrapper = new RenderWrapper($this->formCreator->getBuilder());
        $builderCollectionWrapperCollection = new TypeWrapperCollection();
        $builderCollectionWrapperCollection->add(new TypeWrapper('login', '<div>'));
        $renderWrapper->injectTypeWrapper($builderCollectionWrapperCollection);
        $html = $renderWrapper->render();

        return $html;
    }
    
    
}