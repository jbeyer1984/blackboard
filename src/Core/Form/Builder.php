<?php


namespace src\Core\Form;


use src\Core\Form\Components\InputHidden;
use src\Core\Form\Components\Label;
use src\Core\Form\Components\LabelTextOnly;
use src\Core\Form\Components\Matcher\NotMatchedData;
use src\Core\Form\Components\Provider\BuilderCollection\NestedSelectBoxProvider;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\Form\Components\Request\RequestTree;
use src\Core\Form\Components\TextField;
use src\Core\Form\Components\Type\Bind\BindParameterBase;
use src\Core\Form\Components\Type\CheckBox;
use src\Core\Form\Components\Type\Output\SimpleType;
use src\Core\_Core;
use src\Core\DI\Service;
use src\Utilities\Service\BaseUtilities;

class Builder implements BuilderInterface
{
    /**
     * @var BaseUtilities
     */
    private $base;
    
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var array
     */
    private $entriesOrdered = [];

    /**
     * @var array 
     */
    private $entriesMap = [];

    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @var BindParameterBase
     */
    private $bindParameter;

    /**
     * @var NestedBuilderRelation
     */
    private $nestedBuilderRelation;

    /**
     * @var RequestTree
     */
    private $requestTree;

    /**
     * Builder constructor.
     * @param string $namespace
     * @param Resolver $resolver
     * @param $requestTree
     */
    public function __construct($namespace, Resolver $resolver, RequestTree $requestTree)
    {
        $this->base = Service::get(_Core::class)->getSingle(BaseUtilities::class);
        $this->namespace = $namespace;
        $this->resolver = $resolver;
        $this->requestTree = $requestTree;
    }
    
    /**
     * @param string $identifier
     * @param string $type
     * @param array $options
     * @return mixed|void
     */
    public function add($identifier, $type, $options = [])
    {
        // am I an collection?
        
        // check $type
        //   [text,whatever]
        $simpleTypeOutput = null;
        switch ($type) {
            case 'label_text':
                $identifierLowerCased = strtolower($identifier);
                $nameChain = <<<TXT
{$this->namespace}[label][$identifierLowerCased]
TXT;
                $label = new LabelTextOnly(
                    $nameChain,
                    $identifier // miss use for label text
                );
                $this->entriesOrdered[] = $label;
                break;
            case 'label':
                // input to build
                $simpleTypeOutput       = $this->getSimpleTypeOutput($identifier);
                $label = new Label(
                    $simpleTypeOutput->getNamespace(),
                    $simpleTypeOutput->getValue()
                );
//                $this->addRequestDataBind($identifier, $simpleTypeOutput, $label);
                $this->entriesOrdered[] = $label;
//                $this->entriesMap[$simpleTypeOutput->getNamespace()] = $label;
                break;
            case 'input':
                // input to build
                $simpleTypeOutput = $this->getSimpleTypeOutput($identifier);
                $inputHidden      = new InputHidden(
                    $simpleTypeOutput->getNamespace(),
                    $simpleTypeOutput->getValue()
                );
                $this->addRequestDataBind($identifier, $simpleTypeOutput, $inputHidden);
                $this->entriesOrdered[] = $inputHidden;
//                $this->entriesMap[$simpleTypeOutput->getNamespace()] = $inputHidden;
                break;
            case 'text':
                // text to build
                $simpleTypeOutput = $this->getSimpleTypeOutput($identifier);
                $textField        = new TextField(
                    $simpleTypeOutput->getNamespace(),
                    $simpleTypeOutput->getValue()
                );
                $this->addRequestDataBind($identifier, $simpleTypeOutput, $textField);
                $this->entriesOrdered[] = $textField;
//                $this->entriesMap[$simpleTypeOutput->getNamespace()] = $textField;
                break;
            case 'checkbox':
                // text to build
                $simpleTypeOutput = $this->getSimpleTypeOutput($identifier);
                $checkBox         = new CheckBox(
                    $simpleTypeOutput->getNamespace(),
                    $simpleTypeOutput->getValue(),
                    $simpleTypeOutput->isOn()
                );
                $this->addRequestDataBind($identifier, $simpleTypeOutput, $checkBox);
                $this->entriesOrdered[] = $checkBox;
//                $this->entriesMap[$simpleTypeOutput->getNamespace()] = $checkBox;
                break;
        }
        //   'collection'
        //     nested
        //       $options['type']
        switch ($type) {
            case 'collection':
                // determine type
                if (isset($options['type'])) {
                    $builderCollection = $this->getDeterminedNestedBuilderCollection($identifier, $options);

                    $this->entriesOrdered[] = $builderCollection;
//                    $this->entriesMap[$builderCollection->getNamespace()] = $builderCollection;
                } 
                break;
            case 'choice':
                // determine type
                if (isset($options['type'])) {
                    $options['strategy'] = 'choice'; /** @todo bad approach */
                    $builderCollection = $this->getDeterminedNestedBuilderCollection($identifier, $options);

                    $this->entriesOrdered[] = $builderCollection;
//                    $this->entriesMap[$builderCollection->getNamespace()] = $builderCollection;
                }
                break;
        }
        // check $options
        // assign identifier
        //   for [text, whatever]
        //   OR
        //   nested 
    }

    public function bind(BindParameterBase $bindParameter)
    {
        $this->bindParameter = $bindParameter;
    }

//    /**
//     * @param string $namespace
//     */
//    public function setNamespace($namespace)
//    {
//        $this->namespace = $namespace;
//    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param $identifier
     * @return SimpleType
     */
    private function getSimpleTypeOutput($identifier)
    {
        $nameChain = <<<TXT
{$this->namespace}[{$identifier}]
TXT;
        $data      = $this->resolver->getToResolve();
        $isOn = true;
        if ($data instanceof NotMatchedData) {
            $data = $data->getData();
            $isOn = false;
        }
        $getMethod = 'get' . ucfirst($identifier);
        $exists    = method_exists($data, $getMethod);
        if (!$exists) {
            $className = get_class($data);
            $this->getMethodCollectionWrongException($getMethod, $className);
        }
        
        $value = $data->$getMethod();
        
        return new SimpleType($nameChain, $value, $isOn);
    }

    /**
     * @param $identifier
     * @param $options
     * @return BuilderCollection
     */
    private function getDeterminedNestedBuilderCollection($identifier, $options)
    {
        /** @var AbstractType $formType */
        $formType  = $options['type'];
        // resolve
        $getMethod = 'get' . ucfirst($identifier);
        $data      = $this->resolver->getToResolve();
        if ($data instanceof NotMatchedData) {
            $data = $data->getData();
        }
        $exists    = method_exists($data, $getMethod);
        if (!$exists) {
            $className = get_class($data);
            $this->getMethodCollectionWrongException($getMethod, $className);
        }
        $formTypeResolver = new Resolver($data->$getMethod());
        $formType->resolve($formTypeResolver);
        
        $nameChain = <<<TXT
{$this->namespace}[{$formType->getName()}]
TXT;
        if (isset($options['strategy']) && 'choice' === $options['strategy']) {
            $builder = new Builder($nameChain, $formTypeResolver, $this->requestTree);
            $formType->build($builder); // because of needed bindParameter for SelectBox
            $builderCollectionProvider = new NestedSelectBoxProvider(
                $builder, $formTypeResolver, $formType, $this->requestTree
            );
            $this->nestedBuilderRelation = new NestedBuilderRelation($identifier, $this->namespace);
        } else {
            $builderCollectionProvider = new NestedClassProvider($identifier, $formTypeResolver, $this, $formType, $this->requestTree);
//            $this->nestedBuilderRelation = new NestedBuilderRelation($identifier, $this->namespace);
        }
        
        $builderCollection = $builderCollectionProvider->getDeterminedBuilderCollection($nameChain);

        if (!is_null($this->nestedBuilderRelation)) {
            foreach ($builderCollection->getBuilderCollection() as $builder) {
                $this->nestedBuilderRelation->addChildren($builder->getNamespace());
            }
        }
        
        return $builderCollection;
    }

    /**
     * @return BindParameterBase
     */
    public function getBindParameter()
    {
        return $this->bindParameter;
    }

    /**
     * @return array
     */
    public function getEntriesOrdered()
    {
        return $this->entriesOrdered;
    }

    /**
     * @param string $namespace
     * @param $component
     */
    public function forceAddToEntriesMap($namespace, $component)
    {
        /** @todo check component */
        $this->entriesOrdered[] = $component;
        $this->entriesMap[$namespace] = $component;
    }

    /**
     * @return array
     */
    public function getEntriesMap()
    {
        return $this->entriesMap;
    }

    /**
     * @return Resolver
     */
    public function getResolver()
    {
        return $this->resolver;
    }

    /**
     * @return RequestTree
     */
    public function getRequestTree()
    {
        return $this->requestTree;
    }

    /**
     * @param string $identifier
     * @param SimpleType $simpleTypeOutput
     * @param mixed $htmlType
     */
    private function addRequestDataBind($identifier, SimpleType $simpleTypeOutput, $htmlType)
    {
        $data = $this->resolver->getToResolve();
        if ($data instanceof NotMatchedData) {
            $data = $data->getData();
        }
        $this->requestTree->add(
            $simpleTypeOutput->getNamespace(),
            new RequestDataBind($data, [$identifier], $htmlType, $this)
        );
    }

    /**
     * @return NestedBuilderRelation
     */
    public function getNestedBuilderRelation()
    {
        return $this->nestedBuilderRelation;
    }

    /**
     * @param $getMethod
     * @param $className
     * @throws \Exception
     */
    private function getMethodCollectionWrongException($getMethod, $className)
    {
        $message = <<<TXT
ERROR: method {$getMethod} for nested {$className} collection data was wrong";
TXT;
        throw new \Exception($message);
    }
}