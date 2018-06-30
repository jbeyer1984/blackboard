<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider;


use src\Core\Entity\CollectionInterface;
use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;
use src\Core\Form\Components\Matcher\NotMatchedData;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\Dispatcher\IteratorDataDispatcher;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentSubCollectionBind;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\SubRelationCollection;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\SubRelationCollectionCollection;
use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\Form\Components\Type\Output\SimpleType;
use src\Core\Form\Resolver;

class NestedClassDataIteratorDispatcher
{
    /**
     * @var Builder
     */
    private $builder;
    
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var NestedClassProvider
     */
    private $nestedClassProvider;

    /**
     * @var string
     */
    private $nameChain;

    /**
     * @var AbstractType 
     */
    private $formType;

    /**
     * @var BuilderCollection
     */
    private $builderCollection;

    /**
     * NestedClassDataIteratorDispatcher constructor.
     * @param Resolver $resolver
     * @param AbstractType $formType
     * @param string $nameChain
     */
    public function __construct(Resolver $resolver, AbstractType $formType, $nameChain)
    {
        $this->resolver = $resolver;
        $this->formType = $formType;
        $this->nameChain = $nameChain;
    }

    public function dispatch()
    {
        $this->dispatchDataIterator($this->resolver, $this->formType, $this->nameChain);
    }

    /**
     * @param Resolver $resolver
     * @param AbstractType $formType
     * @param string $nameChain
     */
    private function dispatchDataIterator(
        Resolver $resolver, AbstractType $formType, $nameChain)
    {
        $builderCollection = new BuilderCollection($nameChain);

        $dataDispatcher = new IteratorDataDispatcher($resolver, $nameChain);
        $dataDispatcher->dispatch();
        $dataArray      = $dataDispatcher->getDataArray();
        $dataMatchArray = $dataDispatcher->getDataToMatchArray();

        $subCollectionIdentifierCollection = new SubRelationCollectionCollection();
        $this->addFormAndBuilderBehaviour(
            $dataMatchArray, $dataArray,
            $subCollectionIdentifierCollection, $builderCollection, $formType
        );

        $simpleTypeOutput = new SimpleType($nameChain, '');
        /** @var ProviderDataIterator $data */
        $data = $resolver->getToResolve();
        $providerData     = $data->getData();
        if ($providerData instanceof CollectionInterface) {
            $identifierSubCollectionBind = new ParentSubCollectionBind(
                $data->getPostRelevant(),
                $providerData, $subCollectionIdentifierCollection
            );
            // add request data before filling $nextSubCollectionIdentifierCollection downwards
            $this->addRequestDataBind($nameChain, $simpleTypeOutput, $identifierSubCollectionBind);
        }
    }

    /**
     * @param $dataMatchArray
     * @param $dataArray
     * @param SubRelationCollectionCollection $nextSubCollectionIdentifierCollection
     * @param BuilderCollection $builderCollection
     * @param AbstractType $formType
     */
    private function addFormAndBuilderBehaviour(
        $dataMatchArray, $dataArray,
        SubRelationCollectionCollection $nextSubCollectionIdentifierCollection,
        BuilderCollection $builderCollection, AbstractType $formType
    )
    {
        $builder = null;
        
        if (!empty($dataMatchArray)) {
            foreach ($dataMatchArray as $nameChainCorrelation => $matchData) {
                if (!isset($dataArray[$nameChainCorrelation])) {
                    $notMatchedData  = new NotMatchedData($matchData);
                    $dataForResolver = $notMatchedData;
                } else {
                    $dataForResolver = $dataArray[$nameChainCorrelation];
                }

                if (!is_null($nextSubCollectionIdentifierCollection)) {
                    $subCollectionRelation = new SubRelationCollection($nameChainCorrelation, $dataForResolver);
                    $nextSubCollectionIdentifierCollection->add($subCollectionRelation);
                }

                $chainResolver = new Resolver($dataForResolver);
                $chainResolver->forceToResolve($dataForResolver);

                $builder = new Builder($nameChainCorrelation, $chainResolver, $this->builder->getRequestTree());
                $builderCollection->add($builder);
            }
        } else {
            foreach ($dataArray as $nameChain => $data) {
                if (!is_null($nextSubCollectionIdentifierCollection)) {
                    $subCollectionRelation = new SubRelationCollection($nameChain, $data);
                    $nextSubCollectionIdentifierCollection->add($subCollectionRelation);
                }
                $dataForResolver = $dataArray[$nameChain];
                $chainResolver   = new Resolver($dataForResolver);
                $chainResolver->forceToResolve($dataForResolver);

                $builder = new Builder($nameChain, $chainResolver, $this->builder->getRequestTree());
                $builderCollection->add($builder);
            }
        }
        
        $formType->build($builder);
        $this->builderCollection = $builderCollection;

    }

    /**
     * @param string $identifier
     * @param SimpleType $simpleTypeOutput
     * @param mixed $data
     */
    private function addRequestDataBind($identifier, SimpleType $simpleTypeOutput, $data)
    {
        $this->builder->getRequestTree()->add(
            $simpleTypeOutput->getNamespace(),
            new RequestDataBind(
                $data, [$identifier], null, $this->builder, $this->resolver->getTransformer()
            )
        );
    }
    
    
}