<?php


namespace src\App\Blackboard\FormNew\Type;


use src\App\Blackboard\_Blackboard;
use src\App\Blackboard\BlackboardBaseDataFromJson;
use src\App\Blackboard\EntityNew\ExperienceEntity;
use src\App\Blackboard\EntityNew\ExperienceEntityCollection;
use src\App\Blackboard\EntityNew\Transformer\Post\ExperienceEntityCollectionTransformer;
use src\App\Blackboard\FormNew\Iterator\ExperienceEntityCollectionIterator;
use src\App\Blackboard\FormNew\SymfonyApproach\AbstractType;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderInterface;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Bind\SelectBoxBindParameter;
use src\App\Blackboard\FormNew\SymfonyApproach\ResolverInterface;
use src\Core\DI\Service;

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
        $experienceEntityCollection = Service::get(_Blackboard::class)
            ->getSingle(BlackboardBaseDataFromJson::class)
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