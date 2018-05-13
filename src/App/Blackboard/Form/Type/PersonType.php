<?php


namespace src\App\Blackboard\Form\Type;


use src\App\Blackboard\Entity\PersonEntity;
use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;

class PersonType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        $builder->add('id', 'input');
        $builder->add('Name', 'label_text');
        $builder->add('name', 'text');
        $builder->add('Number', 'label_text');
        $builder->add('number', 'text');
        $builder->add('Sonstiges', 'label_text');
        $builder->add('optional', 'text');
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