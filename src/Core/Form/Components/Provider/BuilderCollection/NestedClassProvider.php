<?php


namespace src\Core\Form\Components\Provider\BuilderCollection;


use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;
use src\Core\Form\Components\Matcher\NotMatchedData;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentSubCollectionBind;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\SubCollectionRelation;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\NextSubCollectionRelationCollection;
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
        $data              = $this->resolver->getToResolve();
        $dataToMatch       = $this->resolver->getMatchData();
        $dataArray = [];
        $dataMatchArray = [];
        if ($data instanceof ProviderDataIterator) {
            if (!empty($dataToMatch)) {
                $dataMatchArray = $this->getDeterminedIteratorDataArray($dataToMatch, $nameChain);
            }
            $dataArray = $this->getDeterminedIteratorDataArray($data, $nameChain);
        } else {
            if (!empty($dataToMatch)) {
                $dataMatchArray = $this->getDeterminedDataArray($dataToMatch, $nameChain);
            }
            $dataArray = $this->getDeterminedDataArray($data, $nameChain);
        }

        $providerData = null;
        $nextSubCollectionIdentifierCollection = null;
        if ($data instanceof ProviderDataIterator) {
            $simpleTypeOutput = new SimpleType($nameChain, '');
            $providerData = $data->getData();
            if ($providerData instanceof CollectionInterface) {
                $nextSubCollectionIdentifierCollection = new NextSubCollectionRelationCollection();
                $identifierSubCollectionBind = new ParentSubCollectionBind(
                    $data->getPostRelevant(),
                    $providerData, $nextSubCollectionIdentifierCollection
                );
                // add request data before filling $nextSubCollectionIdentifierCollection downwards
                $this->addRequestDataBind($nameChain, $simpleTypeOutput, $identifierSubCollectionBind);
            }
        }
        if (!empty($dataMatchArray)) {
            foreach ($dataMatchArray as $nameChainCorrelation => $matchData) {
                if (!isset($dataArray[$nameChainCorrelation])) {
                    $notMatchedData = new NotMatchedData($matchData);
                    $dataForResolver = $notMatchedData;
                } else {
                    $dataForResolver = $dataArray[$nameChainCorrelation];
                }

                if (!is_null($nextSubCollectionIdentifierCollection)) { /** @todo also implement for part below */
                    $subCollectionRelation = new SubCollectionRelation($nameChainCorrelation, $dataForResolver);
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
                    $subCollectionRelation = new SubCollectionRelation($nameChain, $data);
                    $nextSubCollectionIdentifierCollection->add($subCollectionRelation);
                }
                $dataForResolver = $dataArray[$nameChain];
                $chainResolver = new Resolver($dataForResolver);
                $chainResolver->forceToResolve($dataForResolver);

                $builder = new Builder($nameChain, $chainResolver, $this->requestTree);
                $this->formType->build($builder);
                $builderCollection->add($builder);
            }
        }
        
        return $builderCollection;
    }

    /**
     * @param ProviderDataIterator $data
     * @param string $nameChain
     * @return array
     */
    private function getDeterminedIteratorDataArray(ProviderDataIterator $data, $nameChain)
    {
        $providerClass = $data->getProvider();
        $provider      = new $providerClass($data->getData());
        $dataArray = [];
        foreach ($provider as $iteratorClass) {
            if ($data->getIteratorClass() == get_class($iteratorClass)) {
                $getMethod               = 'get' . ucfirst($data->getIdentifier());
                $iteratorClassIdentifier = $iteratorClass->$getMethod();
                $iteratorNameChain       = <<<TXT
{$nameChain}[{$iteratorClassIdentifier}]
TXT;
                $dataArray[$iteratorNameChain] = $iteratorClass;
            }
        }
        
        return $dataArray;
    }

    /**
     * @param array $dataToIterate
     * @param $nameChain
     * @return array
     */
    private function getDeterminedDataArray($dataToIterate, $nameChain)
    {
        $dataArray = [];
        $iteratorNameChain = <<<TXT
{$nameChain}
TXT;
        if (!is_array($dataToIterate)) {
            $dataArray[$iteratorNameChain] = $dataToIterate;
        } else {
            foreach ($dataToIterate as $index => $iteratorClass) {
                
                $dataArray[$iteratorNameChain][$index] = $iteratorClass;
            }    
        }
        
        return $dataArray;
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
}