<?php


namespace src\App\Blackboard\Form;


use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Form\Type\EntryType;
use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Render\Components\TypeWrapper;
use src\Core\Form\Components\Render\RenderWrapper;
use src\Core\Form\Creator\FormCreator;

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