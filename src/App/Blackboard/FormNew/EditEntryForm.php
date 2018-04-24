<?php


namespace src\App\Blackboard\FormNew;


use src\App\Blackboard\EntityNew\EntryEntity;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\Collection\TypeWrapperCollection;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components\TypeWrapper;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\RenderWrapper;
use src\App\Blackboard\FormNew\SymfonyApproach\Creator\FormCreator;
use src\App\Blackboard\FormNew\Type\EntryType;

class EditEntryForm
{
    /**
     * @var EntryEntity
     */
    private $entryEntity;

    /**
     * @var FormCreator
     */
    private $formCreator;

    /**
     * EditEntryForm constructor.
     * @param EntryEntity $entryEntity
     */
    public function __construct(EntryEntity $entryEntity)
    {
        $this->entryEntity = $entryEntity;
        
        $this->init();
    }

    protected function init()
    {
        $this->formCreator = new FormCreator(new EntryType(), $this->entryEntity);
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