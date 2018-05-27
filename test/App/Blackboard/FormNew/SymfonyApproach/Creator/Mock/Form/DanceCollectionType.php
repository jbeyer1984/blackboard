<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form;

use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\ResolverInterface;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Iterator\DanceEntityCollectionIterator;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post\DanceEntityCollectionTransformer;
use test\App\Blackboard\FormNew\SymfonyApproach\Factory\BlackboardBaseDataFactory;

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
        $factory = new BlackboardBaseDataFactory();
        $blackboardBaseDataFromJson = $factory->getBlackboardBaseDataFromJson();
        $danceEntityCollection = $blackboardBaseDataFromJson
            ->getDanceEntityCollection()
        ;
            
        $resolver->setDefault([
            'data_class' => DanceEntityCollection::class,
            'iterable' => [
                'provider' => DanceEntityCollectionIterator::class,
                'data_class' => DanceEntity::class,
                'identifier' => 'id',
                'data_match' => [
                    'provider' => DanceEntityCollectionIterator::class,
                    'data' => $danceEntityCollection,
                    'data_class' => DanceEntity::class,
                    'identifier' => 'id',
                    'add_attributes' => ['name']
                ]
            ],
            'transformer' => [
                'post' => DanceEntityCollectionTransformer::class
            ]
        ]);
    }

    public function getName()
    {
        return 'dance';
    }

}