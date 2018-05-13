<?php


namespace src\App\Blackboard\Form;


use src\App\Blackboard\Entity\DanceEntityCollection;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\PersonEntity;
use src\App\Blackboard\Form\Type\EntryType;
use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Render\Components\TypeWrapper;
use src\Core\Form\Components\Render\RenderWrapper;
use src\Core\Form\Creator\FormCreator;

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
        $entryEntity = new EntryEntity(0, $now, new PersonEntity(0, '', '', ''), new DanceEntityCollection());
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