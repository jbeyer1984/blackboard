<?php


namespace src\App\Blackboard\Form\Type;


use src\App\Blackboard\Entity\ExperienceEntity;
use src\App\Blackboard\Entity\ExperienceEntityCollection;
use src\App\Blackboard\Factory\BlackboardBaseDataFactory;
use src\App\Blackboard\Form\Iterator\ExperienceEntityCollectionIterator;
use src\App\Blackboard\Form\Transformer\Post\ExperienceEntityCollectionTransformer;
use src\Core\Form\AbstractType;
use src\Core\Form\BuilderInterface;
use src\Core\Form\Components\Type\Bind\SelectBoxBindParameter;
use src\Core\Form\ResolverInterface;

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
        $factory = new BlackboardBaseDataFactory();
        $blackboardBaseData = $factory->getBlackboardBaseDataFromJson();
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