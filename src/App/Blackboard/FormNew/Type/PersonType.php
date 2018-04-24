<?php


namespace src\App\Blackboard\FormNew\Type;


use src\App\Blackboard\EntityNew\PersonEntity;
use src\App\Blackboard\FormNew\SymfonyApproach\AbstractType;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderInterface;
use src\App\Blackboard\FormNew\SymfonyApproach\ResolverInterface;

class PersonType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        $builder->add('id', 'input');
        $builder->add('Name', 'label_text');
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