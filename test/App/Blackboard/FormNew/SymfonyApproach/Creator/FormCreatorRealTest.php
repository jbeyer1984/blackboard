<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator;


use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Render\Components\TypeWrapper;
use src\Core\Form\Components\Render\RenderWrapper;
use src\Core\Form\Creator\FormCreator;
use src\App\Blackboard\Form\Type\EntryType;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\EntryEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\PersonEntity;
use test\Core\BaseFramework;

class FormCreatorRealTest extends BaseFramework
{
    public function testReal()
    {
        $now = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $entryEntity = new EntryEntity(0, $now, new PersonEntity(0, 'sss'), new DanceEntityCollection());
        $formCreator = new FormCreator(new EntryType(), $entryEntity);
        $formCreator->build();
        $renderWrapper = new RenderWrapper($formCreator->getBuilder());
        $builderCollectionWrapperCollection = new TypeWrapperCollection();
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[person]', '<div>'));
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[dance]', '<div>'));
        $renderWrapper->injectTypeWrapper($builderCollectionWrapperCollection);
        $html = $renderWrapper->render();
        
        $formData = $html;
    }
}