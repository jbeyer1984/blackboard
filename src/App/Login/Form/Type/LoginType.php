<?php


namespace src\App\Login\Form\Type;


use src\App\Login\Entity\LoginEntity;
use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;

class LoginType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        /** @var Builder $builder */
        $builder->add('password', 'text');
    }

    public function resolve(ResolverInterface $resolver)
    {
        $resolver->setDefault([
            'data_class' => LoginEntity::class
        ]);
    }

    public function getName()
    {
        return 'login';
    }
}