<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form;


use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\PersonEntity;

class PersonType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        $builder->add('id', 'input');
        $builder->add('name', 'text');
    }

    public function resolve(ResolverInterface $resolver)
    {
        $resolver->setDefault([
            'data_class' => PersonEntity::class
        ]);
    }

    public function getName()
    {
        return 'person';
    }

}