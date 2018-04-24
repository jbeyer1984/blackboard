<?php


namespace src\App\Blackboard\FormNew;


use src\App\Blackboard\EntityNew\DanceEntityCollection;
use src\App\Blackboard\EntityNew\EntryEntity;
use src\App\Blackboard\EntityNew\PersonEntity;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Collection\TypeWrapperCollection;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\TypeWrapper;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\RenderWrapper;
use src\App\Blackboard\FormNew\SymfonyApproach\Creator\FormCreator;
use src\App\Blackboard\FormNew\Type\EntryType;

class AddEntryForm
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
        $now = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $entryEntity = new EntryEntity(0, $now, new PersonEntity(0, ''), new DanceEntityCollection());
        $formCreator = new FormCreator(new EntryType(), $entryEntity);
        
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
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[person]', '<div>'));
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[dance]', '<div>'));
        $renderWrapper->injectTypeWrapper($builderCollectionWrapperCollection);
        $html = $renderWrapper->render();

        return $html;
    }

    /**
     * @return FormCreator
     */
    public function getFormCreator()
    {
        return $this->formCreator;
    }
}