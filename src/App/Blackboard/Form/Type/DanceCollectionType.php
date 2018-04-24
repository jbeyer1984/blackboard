<?php


namespace src\App\Blackboard\Form\Type;


use src\App\Blackboard\_Blackboard;
use src\App\Blackboard\BlackboardBaseDataFromJson;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\DanceEntityCollection;
use src\App\Blackboard\Form\Iterator\DanceEntityCollectionIterator;;
use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;
use src\Core\DI\Service;

class DanceCollectionType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        $builder->add('id', 'input');
        $builder->add('name', 'label');
        $builder->add('name', 'checkbox');
        $builder->add('experienceEntityCollection', 'choice', [
            'type' => new ExperienceCollectionType(),
        ]);
    }

    public function resolve(ResolverInterface $resolver)
    {
        $danceEntityCollection = Service::get(_Blackboard::class)
            ->getSingle(BlackboardBaseDataFromJson::class)
            ->getDanceEntityCollection()
        ;
            
        $resolver->setDefault([
            'data_class' => DanceEntityCollection::class,
            'iterable' => [
                'provider' => DanceEntityCollectionIterator::class,
                'data_class' => DanceEntity::class,
                'identifier' => 'id',
                'post_relevant' => ['name'],
                'data_match' => [
                    'provider' => DanceEntityCollectionIterator::class,
                    'data' => $danceEntityCollection,
                    'data_class' => DanceEntity::class,
                    'identifier' => 'id',
                    'add_attributes' => ['name']
                ]
            ]
        ]);
    }

    public function getName()
    {
        return 'dance';
    }

}