<?php


namespace src\App\Blackboard\FormNew\Type;


use src\App\Blackboard\EntityNew\EntryEntity;
use src\App\Blackboard\FormNew\SymfonyApproach\AbstractType;
use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderInterface;
use src\App\Blackboard\FormNew\SymfonyApproach\ResolverInterface;

class EntryType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        /** @var Builder $builder */
        $builder->add('id', 'input');
        $builder->add('person', 'collection', [
            'type' => new PersonType()
        ]);
        $builder->add('danceCollection', 'collection', [
            'type' => new DanceCollectionType()
        ]);
    }

    public function resolve(ResolverInterface $resolver)
    {
        $resolver->setDefault([
            'data_class' => EntryEntity::class
        ]);
    }

    public function getName()
    {
        return 'entry';
    }

}