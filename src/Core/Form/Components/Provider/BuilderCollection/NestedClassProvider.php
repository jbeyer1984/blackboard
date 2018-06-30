<?php


namespace src\Core\Form\Components\Provider\BuilderCollection;


use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;
use src\Core\Form\Components\Matcher\NotMatchedData;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\Dispatcher\DataDispatcher;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\Dispatcher\IteratorDataDispatcher;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentSubCollectionBind;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\SubRelationCollection;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\SubRelationCollectionCollection;
use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\Form\Components\Request\RequestTree;
use src\Core\Form\Components\Type\Output\SimpleType;
use src\Core\Form\Resolver;
use src\Core\Entity\CollectionInterface;

class NestedClassProvider
{
    /**
     * @var string
     */
    private $setIdentifier;
    
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var AbstractType
     */
    private $formType;

    /**
     * @var array
     */
    private $requestTree;

    /**
     * NestedClassProvider constructor.
     * @param $setIdentifier
     * @param Resolver $resolver
     * @param Builder $builder
     * @param AbstractType $formType
     * @param RequestTree $requestTree
     */
    public function __construct($setIdentifier, Resolver $resolver, Builder $builder, AbstractType $formType, RequestTree $requestTree)
    {
        $this->resolver    = $resolver;
        $this->formType    = $formType;
        $this->requestTree = $requestTree;
        $this->builder = $builder;
        $this->setIdentifier = $setIdentifier;
    }

    /**
     * @param string $builderCollectionIdentifier
     * @return BuilderCollection
     */
    public function getDeterminedBuilderCollection($builderCollectionIdentifier)
    {
        $nameChain         = $builderCollectionIdentifier;
        $builderCollection = new BuilderCollection($nameChain);
        $dataDispatcher = null;
        $data = $this->resolver->getToResolve();

        $subCollectionIdentifierCollection = new SubRelationCollectionCollection();

        if ($data instanceof ProviderDataIterator) {
            $dataDispatcher = new IteratorDataDispatcher($this->resolver, $nameChain);
            $dataDispatcher->dispatch();
            $dataArray = $dataDispatcher->getDataArray();
            $dataMatchArray = $dataDispatcher->getDataToMatchArray();

            $this->addFormAndBuilderBehaviour(
                $dataMatchArray, $dataArray,
                $subCollectionIdentifierCollection, $builderCollection
            );

            $simpleTypeOutput = new SimpleType($nameChain, '');
            $providerData = $data->getData();
            if ($providerData instanceof CollectionInterface) {
                $identifierSubCollectionBind = new ParentSubCollectionBind(
                    $data->getPostRelevant(),
                    $providerData, $subCollectionIdentifierCollection
                );
                // add request data before filling $nextSubCollectionIdentifierCollection downwards
                $this->addRequestDataBind($nameChain, $simpleTypeOutput, $identifierSubCollectionBind);
            }
        } else {
            $dataDispatcher = new DataDispatcher($this->resolver, $nameChain);
            $dataDispatcher->dispatch();
            $dataArray = $dataDispatcher->getDataArray();
            $dataMatchArray = $dataDispatcher->getDataToMatchArray();

            $this->addFormAndBuilderBehaviour(
                $dataMatchArray, $dataArray,
                $subCollectionIdentifierCollection, $builderCollection
            );
        }
        
        return $builderCollection;
    }

    

    /**
     * @param string $identifier
     * @param SimpleType $simpleTypeOutput
     * @param mixed $data
     */
    private function addRequestDataBind($identifier, SimpleType $simpleTypeOutput, $data)
    {
        $this->requestTree->add(
            $simpleTypeOutput->getNamespace(),
            new RequestDataBind(
                $data, [$identifier], null, $this->builder, $this->resolver->getTransformer()
            )
        );
    }

    /**
     * @param $dataMatchArray
     * @param $dataArray
     * @param SubRelationCollectionCollection $nextSubCollectionIdentifierCollection
     * @param BuilderCollection $builderCollection
     */
    private function addFormAndBuilderBehaviour(
        $dataMatchArray, $dataArray,
        SubRelationCollectionCollection $nextSubCollectionIdentifierCollection,
        BuilderCollection $builderCollection
    )
    {
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

                $builder = new Builder($nameChainCorrelation, $chainResolver, $this->requestTree);
                $this->formType->build($builder);
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

                $builder = new Builder($nameChain, $chainResolver, $this->requestTree);
                $this->formType->build($builder);
                $builderCollection->add($builder);
            }
        }
    }
}