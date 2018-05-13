<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form;


use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\EntryEntity;

class EntryType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        // to mock
    }

    public function resolve(ResolverInterface $resolver)
    {
        $resolver->setDefault([
            'data_class' => EntryEntity::class,
        ]);
    }

    public function getName()
    {
        return 'entry';
    }

}