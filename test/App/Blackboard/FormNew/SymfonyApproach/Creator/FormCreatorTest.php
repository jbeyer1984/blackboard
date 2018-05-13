<?php
/**
 * Created by PhpStorm.
 * User: Jens
 * Date: 02.04.2018
 * Time: 20:03
 */

namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator;

use src\Core\Form\BuilderCollection;
use src\Core\Form\Components\InputHidden;
use src\Core\Form\Creator\FormCreator;
use src\Router\Request\Post;
use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;
use src\Core\Form\Components\Provider\NestedRead\NestedNamespaces;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedBuilder;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedComponents;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedRender;
use src\Core\Form\Components\Render\Components\TypeWrapper;
use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Render\RenderWrapper;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\EntryEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntityCollection;
use src\Core\Form\Builder;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\PersonEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form\DanceCollectionType;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form\EntryType;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Form\PersonType;
use test\Utilities\Service\BaseUtilitiesFactory;

class FormCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseUtilities
     */
    private $base;
    
    public function setUp()
    {
        $this->base = BaseUtilitiesFactory::getCreatedBaseUtilities();
//        $entryFile = Service::get(_Blackboard::class)->getSingle(EntryFile::class);
//        $testBaseDataFromJson = new testBaseDataFromJson($entryFile);
//        Service::get(_Blackboard::class)->inject(BlackboardBaseDataFromJson::class, $testBaseDataFromJson);
    }
    
    public function testBuild_FormCreator_existingSimpleField()
    {
        $personalEntity = new PersonEntity(0, 'Horst Schlämmer');
        $entryEntity = new EntryEntity(0, '2018-04-02 00:00:00', $personalEntity, new DanceEntityCollection());
        
        $entryTypeMock = $this->getMockBuilder(EntryType::class)
            ->setMethods(['build'])
            ->getMock()
        ;
        $entryTypeMock->method('build')->willReturnCallback(function ($builder) {
            /** @var Builder $builder */
            $builder->add('id', 'input');
        });
//        $entryTypeMock->method('resolve')->willReturnCallback(function (ResolverInterface $resolver) {
//            $resolver->setDefault([
//                'data_class' => EntryEntity::class,
//            ]);
//        });
        /** @var EntryType $entryTypeMock */
        $formCreator = new FormCreator($entryTypeMock, $entryEntity);
        $formCreator->build();
        
        $entriesOrdered = $formCreator->getBuilder()->getEntriesOrdered();
        
        $expected = [
            new InputHidden('entry[id]', 0)
        ];
        
        $this->assertEquals($expected, $entriesOrdered);
    }

    public function testBuild_FormCreator_existingCollectionNested()
    {
        $personalEntity = new PersonEntity(0, 'Horst Schlämmer');
        $entryEntity = new EntryEntity(0, '2018-04-02 00:00:00', $personalEntity, new DanceEntityCollection());

        $entryTypeMock = $this->getMockBuilder(EntryType::class)
            ->setMethods(['build'])
            ->getMock()
        ;
        $entryTypeMock->method('build')->willReturnCallback(function ($builder) {
            /** @var Builder $builder */
//            $builder->add('id', 'input');
            $builder->add('person', 'collection', [
                'type' => new PersonType()
            ]);
        });

        /** @var EntryType $entryTypeMock */
        $formCreator = new FormCreator($entryTypeMock, $entryEntity);
        $formCreator->build();

        $entriesOrdered = $formCreator->getBuilder()->getEntriesOrdered();

        $personTypeMock = $this->getMockBuilder(PersonType::class)
            ->setMethods(['getName'])
            ->getMock()
        ;
        $personTypeMock->method('getName')->willReturn('entry[person]');
        /** @var PersonType $personTypeMock */
        $personFormCreator = new FormCreator($personTypeMock, $personalEntity);
        $personFormCreator->build();

        $builderCollection = new BuilderCollection('entry[person]');
        $builderCollection->add($personFormCreator->getBuilder());
        $expected = [
            $builderCollection
        ];

        $this->assertEquals($expected, $entriesOrdered);
    }

    public function testBuild_FormCreator_existingEntityCollectionNested()
    {
        $personalEntity = new PersonEntity(0, 'Horst Schlämmer');
        $danceCollection = new DanceEntityCollection();
        $experienceEntityCollectionSalsa = new ExperienceEntityCollection();
        $experienceEntityCollectionSalsa->add(new ExperienceEntity(1, 'Totaler Anfänger'));
//        $experienceEntityCollectionKizomba = new ExperienceEntityCollection();
//        $experienceEntityCollectionKizomba->add(new ExperienceEntity(2, 'Anfänger'));
        $danceCollection->add(new DanceEntity(1, 'Salsa', $experienceEntityCollectionSalsa));
//        $danceCollection->add(new DanceEntity(2, 'Kizomba', $experienceEntityCollectionKizomba));
        $entryEntity = new EntryEntity(0, '2018-04-02 00:00:00', $personalEntity, $danceCollection);
        
        $entryTypeMock = $this->getMockBuilder(EntryType::class)
            ->setMethods(['build'])
            ->getMock()
        ;
        $entryTypeMock->method('build')->willReturnCallback(function ($builder) {
            /** @var Builder $builder */
            $builder->add('id', 'input');
            $builder->add('person', 'collection', [
                'type' => new PersonType()
            ]);
            $builder->add('danceCollection', 'collection', [
                'type' => new DanceCollectionType()
            ]);
        });

        /** @var EntryType $entryTypeMock */
        $formCreator = new FormCreator($entryTypeMock, $entryEntity);
        $formCreator->build();
        

        $entriesOrdered = $formCreator->getBuilder()->getEntriesOrdered();
        $entriesMap = $formCreator->getBuilder()->getEntriesMap();
//        $this->base->getLogger()->log($entriesMap, '$entriesMap');
        $nestedNamespaces = new NestedNamespaces($formCreator->getBuilder());
        $entriesMapNamespaceNested = $nestedNamespaces->getEntriesMapNested();
//        $this->base->getLogger()->log($entriesMapNamespaceNested, '$entriesMapNamespaceNested');
        
//        $nestedComponent = new NestedComponent($formCreator->getBuilder());
//        $component = $nestedComponent->getNestedComponentByNamespace('entry[dance][0][experience]');
//        $this->base->getLogger()->log($component, '$component');

        $nestedComponent = new NestedOrderedComponents($formCreator->getBuilder());
//        $components = $nestedComponent->getNestedComponentsByNamespace('entry[dance][#][name]');
//        $components = $nestedComponent->getNestedComponentsByNamespace('entry[dance][#][experience]');
//        $components = $nestedComponent->getNestedComponentsByNamespace('entry[person][#]');
//        $this->base->getLogger()->log($components, '$component');
        
        $nestedOrderRendered = new NestedOrderedRender($formCreator->getBuilder());
        $html = $nestedOrderRendered->getEntriesNestedRendered();
//        $this->base->getLogger()->log($html, '$html');
        
        $renderWrapper = new RenderWrapper($formCreator->getBuilder());
        $builderCollectionWrapperCollection = new TypeWrapperCollection();
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[person]', '<div>'));
        $builderCollectionWrapperCollection->add(new TypeWrapper('entry[dance]', '<div>'));
        $renderWrapper->injectTypeWrapper($builderCollectionWrapperCollection);
        $html = $renderWrapper->render();
//        $this->base->getLogger()->log($html, '$html');
        
        
        $nestedOrderedBuilder = new NestedOrderedBuilder($formCreator->getBuilder());
//        $builder = $nestedOrderedBuilder->getEntriesNestedRenderedByNamespace('entry[person]');
        $builder = $nestedOrderedBuilder->getBuilderNestedByNamespace('entry[dance]');

        $requestTree = $formCreator->getBuilder()->getRequestTree();
        $postTree = $requestTree->getPostTree();
        $arr = array_keys($postTree);
        $this->base->getLogger()->log($arr, '$arr');
        $check = $postTree['entry[dance][2][experience]'];
//        $this->base->getLogger()->log($check, '$check');

        $builders = $nestedOrderedBuilder->getBuilderNestedByNamespace('entry[dance]');
        
        foreach ($builders as $builder) {
            if ($builder instanceof BuilderCollection) {
                foreach ($builder->getBuilderCollection() as $bui) {
                    $bui->getNestedBuilderRelation()->printIt();
                }
            }
        }
        
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->setMethods(['getPost'])
            ->getMock()
        ;
        $postMock = $this->getMockBuilder(Post::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAllParams'])
            ->getMock()
        ;
        $requestMock->method('getPost')->willReturn($postMock);
        $request = [
            'entry' => [
                'person' => [
                    'name' => 'Ernst Lachhaft'
                ],
                'dance' => [
                    1 => [
                        'id' => 1,
//                        'name' => 'Salsa',
                        'experience' => 4
                    ],
                    3 => [
                        'id' => 3,
                        'name' => 'Bachata',
                        'experience' => 3
                    ]
                ],
            ]
        ];
        $postMock->method('getAllParams')->willReturn($request);
        
        $formCreator = new FormCreator($entryTypeMock, $entryEntity);
//        $formCreator->build();
        $formCreator->handleRequest($requestMock);

        $components = $nestedComponent->getNestedComponentsByNamespace('entry[person][name]');


        $nestedOrderedBuilder = new NestedOrderedBuilder($formCreator->getBuilder());
        $builders = $nestedOrderedBuilder->getBuilderNestedByNamespace('entry[person]');

        
        $taki = 0;
    }

    public function testReal()
    {
        $now = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $entryEntity = new EntryEntity(0, $now, new PersonEntity(0, 'sss'), new DanceEntityCollection());
        $formCreator = new FormCreator(new EntryType(), $entryEntity);
        $formCreator->build();
        $nestedOrderRendered = new NestedOrderedRender($formCreator->getBuilder());
        $html = $nestedOrderRendered->getEntriesNestedRendered();
        $formData = $html;
    }
    
}
