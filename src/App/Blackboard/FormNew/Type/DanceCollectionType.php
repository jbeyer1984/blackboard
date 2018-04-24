<?php


namespace src\App\Blackboard\FormNew\Type;


use src\App\Blackboard\_Blackboard;
use src\App\Blackboard\BlackboardBaseDataFromJson;
use src\App\Blackboard\EntityNew\DanceEntity;
use src\App\Blackboard\EntityNew\DanceEntityCollection;
use src\App\Blackboard\FormNew\Iterator\DanceEntityCollectionIterator;
use src\App\Blackboard\FormNew\SymfonyApproach\AbstractType;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderInterface;
use src\App\Blackboard\FormNew\SymfonyApproach\ResolverInterface;
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