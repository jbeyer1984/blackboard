<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\BuilderCollection;


use src\App\Blackboard\FormNew\SymfonyApproach\AbstractType;
use src\App\Blackboard\FormNew\SymfonyApproach\Builder;
use src\App\Blackboard\FormNew\SymfonyApproach\BuilderCollection;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Matcher\NotMatchedData;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Provider\ProviderDataIterator;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Request\RequestDataBind;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Request\RequestTree;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Choice\SelectBox;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Choice\SelectBoxOption;
use src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Output\SimpleType;
use src\App\Blackboard\FormNew\SymfonyApproach\Resolver;

class NestedSelectBoxProvider
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
     * @var AbstractType
     */
    private $formType;

    /**
     * @var array
     */
    private $requestTree;

    /**
     * NestedSelectBoxProvider constructor.
     * @param Builder $builder
     * @param Resolver $resolver
     * @param AbstractType $formType
     * @param RequestTree $requestTree
     */
    public function __construct(Builder $builder, Resolver $resolver, AbstractType $formType, RequestTree $requestTree)
    {
        $this->builder     = $builder;
        $this->resolver    = $resolver;
        $this->formType    = $formType;
        $this->requestTree = $requestTree;
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
        $isProvider = $data instanceof ProviderDataIterator;
        $dataToMatch       = $this->resolver->getMatchData();
        $selectBox = new SelectBox($nameChain);
        $bindParameter = $this->builder->getBindParameter()->getBindMap();
        
        // foreach $data
        // foreach $matchdata
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
        
        // matching
        if (!empty($dataMatchArray)) {
            foreach ($dataMatchArray as $nameChainCorrelation => $matchData) {
                if (!isset($dataArray[$nameChainCorrelation])) {
                    $notMatchedData = new NotMatchedData($matchData);
                    $optionForSelectBox = $notMatchedData;
                } else {
                    $optionForSelectBox = $dataArray[$nameChainCorrelation];
                }

                list($value, $displayValue) = $this->getDeterminedSelectOptionParameters($bindParameter, $optionForSelectBox);
                $selectBoxOption = new SelectBoxOption($nameChainCorrelation, $value, $displayValue);
                if ($optionForSelectBox instanceof NotMatchedData) {
                    $selectBoxOption->setOn(false);
                } else {
                    $selectBoxOption->setOn(true);
                }
                $selectBox->addOption($selectBoxOption);

            }
        } else {
            foreach ($dataArray as $nameChain => $data) {
                list($value, $displayValue) = $this->getDeterminedSelectOptionParameters($bindParameter, $data);
                $selectBoxOption = new SelectBoxOption($nameChain, $value, $displayValue);
                if ($data instanceof NotMatchedData) {
                    $selectBoxOption->setOn(false);
                } else {
                    $selectBoxOption->setOn(true);
                }
                $selectBox->addOption($selectBoxOption);
            }
        }
        
        
        if ($isProvider) {
//            $providerClass = $data->getProvider();
//            $provider      = new $providerClass($data->getData());
//            
//            $identifier = $data->getIdentifier();
//            foreach ($provider as $iteratorClass) {
//                if ($data->getIteratorClass() == get_class($iteratorClass)) {
////                    $nameMethod               = 'get' . ucfirst($data->getIdentifier());
////                        $iteratorClassIdentifier = $iteratorClass->$getMethod();    
////                    $identifier = $identifierForSelectBox;
//                    list($value, $displayValue) = $this->getDerterminedSelectOptionParameters($bindParameter, $iteratorClass);
//                    $selectBox->addOption(new SelectBoxOption($identifier, $value, $displayValue));
//                }
//            }
////            $chainResolver           = new Resolver($iteratorClass);
////            $chainResolver->forceToResolve($iteratorClass);
////                    $iteratorNameChain = <<<TXT
////{$nameChain}[{$iteratorClassIdentifier}]
////TXT;
            $simpleTypeOutput = new SimpleType($nameChain, '');
            $identifierForSelectBox = $bindParameter['value'];
            $this->addRequestDataBind($identifierForSelectBox, $simpleTypeOutput, $selectBox);
            $builder           = new Builder($nameChain, $this->resolver, $this->requestTree); // pseudo entry
            $builder->forceAddToEntriesMap($nameChain, $selectBox); // pseudo entry
//            $this->formType->build($builder);
            $builderCollection->add($builder);
            
        } else {
            throw new \Exception('default case has to be implemented');
//            $builder = new Builder($nameChain, $this->resolver);
//            $this->formType->build($builder);
//            $builderCollection->add($builder);
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
     * @param mixed $htmlType
     */
    private function addRequestDataBind($identifier, SimpleType $simpleTypeOutput, $htmlType)
    {
//        $dump = print_r($identifier, true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $identifier ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        $data = $this->resolver->getToResolve();
        if ($data instanceof NotMatchedData) { /** @todo think about this approach */
            $data = $data->getData();
        }
        $this->requestTree->add(
            $simpleTypeOutput->getNamespace(),
            new RequestDataBind(
                $data, [$identifier], $htmlType, $this->builder, $this->resolver->getTransformer()
            )
        );
    }

    /**
     * @param $bindParameter
     * @param $iteratorClass
     * @return array
     */
    protected function getDeterminedSelectOptionParameters($bindParameter, $iteratorClass)
    {
        $value        = 'XXERROR:SELECTBOX:XX';
        $displayValue = 'XXERROR:SELECTBOX:XX';
        if ($iteratorClass instanceof NotMatchedData) {
            $iteratorClass = $iteratorClass->getData();
        }
        if (isset($bindParameter['value'])) {
            $valueMethod = 'get' . ucfirst($bindParameter['value']);
            $value       = $iteratorClass->$valueMethod();
        }
        if (isset($bindParameter['display_value'])) {
            $valueDisplayMethod = 'get' . ucfirst($bindParameter['display_value']);
            $displayValue       = $iteratorClass->$valueDisplayMethod();
        }

        return array($value, $displayValue);
    }
}