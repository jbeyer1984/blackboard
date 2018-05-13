<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form;


use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\Components\Type\Bind\SelectBoxBindParameter;
use src\Core\Form\ResolverInterface;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Iterator\ExperienceEntityCollectionIterator;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post\ExperienceEntityCollectionTransformer;
use test\App\Blackboard\FormNew\SymfonyApproach\Factory\BlackboardBaseDataFactory;

class ExperienceCollectionType extends AbstractType
{
    public function build(BuilderInterface $builder)
    {
        $builder->bind(new SelectBoxBindParameter([
            'value' => 'id',
            'display_value' => 'name'
        ]));
    }

    public function resolve(ResolverInterface $resolver)
    {
        $blackboardBaseData = BlackboardBaseDataFactory::getBlackboardBaseDataFromJson();
        $experienceEntityCollection = $blackboardBaseData
            ->getExperienceEntityCollection()
        ;
        
        $resolver->setDefault([
            'data_class' => ExperienceEntityCollection::class,
            'iterable' => [
                'provider' => ExperienceEntityCollectionIterator::class,
                'data_class' => ExperienceEntity::class,
                'identifier' => 'id',
                'data_match' => [
                    'provider' => ExperienceEntityCollectionIterator::class,
                    'data' => $experienceEntityCollection,
                    'data_class' => ExperienceEntity::class,
                    'identifier' => 'id',
                    'add_attributes' => ['name']
                ]
            ],
            'transformer' => [
                'post' => ExperienceEntityCollectionTransformer::class
            ]
        ]);
    }

    public function getName()
    {
        return 'experience';
    }

}