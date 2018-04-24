<?php


namespace src\App\Blackboard\Form\Type;


use src\App\Blackboard\Entity\EntryEntity;
use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;

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