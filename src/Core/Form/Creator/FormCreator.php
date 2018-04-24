<?php


namespace src\Core\Form\Creator;


use src\Core\Form\AbstractType;
use src\Core\Form\Builder;
use src\Core\Form\Components\Matcher\NotMatchedData;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentSubCollectionBind;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedComponents;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\Form\Components\Request\RequestTree;
use src\Core\Form\NestedBuilderRelation;
use src\Core\Form\Resolver;
use src\Router\Request\Request;

class FormCreator
{
    /**
     * @var AbstractType
     */
    private $formType;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * FormCreator constructor.
     * @param AbstractType $formType
     * @param $data
     */
    public function __construct(AbstractType $formType, $data)
    {
        $this->formType = $formType;
        $this->data = $data;
        $this->init();
    }

    protected function init()
    {
        $this->resolver = new Resolver($this->data);
        $requestTree = new RequestTree();
        $this->builder = new Builder($this->formType->getName(), $this->resolver, $requestTree);
    }
    
    public function build()
    {
        $this->formType->resolve($this->resolver);
        $this->formType->build($this->builder);
    }

    public function handleRequest(Request $request)
    {
        $request = $request->getPost()->getAllParams();
        $this->formType->resolve($this->resolver);
        $this->formType->build($this->builder);
        
        $nestedComponentSearcher = new NestedOrderedComponents($this->getBuilder());
        
        $setLater = [];

        foreach ($this->builder->getRequestTree()->getPostTree() as $identifier => $component) {
            $components = $nestedComponentSearcher->getNestedComponentsByNamespace($identifier);
            // check nested child relation exists
            if (!empty($components)) {
                if ($component instanceof RequestDataBind) {
                    $builder = $component->getBuilder();
                    if (!is_null($builder) && !is_null($builder->getNestedBuilderRelation())) {
                        foreach ($builder->getNestedBuilderRelation()->getChildrenIdentifiers() as $childRelationIdentifier) {
                            $setLater[$childRelationIdentifier] = [
                                'nestedRelation' => $builder->getNestedBuilderRelation(),
                                'data' => $component
                            ];
                        }
                    }
                }
            }
            if ($component instanceof RequestDataBind) {
                if ($component->getData() instanceof ParentSubCollectionBind) {
                    /** @var ParentSubCollectionBind $parentSubCollectionBind */
                    $parentSubCollectionBind = $component->getData();
                    $parentCollection = $parentSubCollectionBind->getParentCollection();
                    $nextSubCollectionIdentifierCollection = 
                        $parentSubCollectionBind->getSubCollectionRelationCollection()
                    ;
//                    if (method_exists($parentCollection, 'clear')) { /** @todo other approach maybe */
//                            $parentCollection->clear();
//                    }
                    foreach ($nextSubCollectionIdentifierCollection->getCollection() as $subCollectionRelation) {
                        $nameChain = $subCollectionRelation->getNameChain();
                        if (false !== $this->requestNestedByString($nameChain, $request)) {
                            if (method_exists($parentCollection, 'add')) {
                                if ($subCollectionRelation->getData() instanceof NotMatchedData) {
                                    $attributesCheck = true;
                                    $nameChainSubCollection = $subCollectionRelation->getNameChain();
                                    foreach ($parentSubCollectionBind->getPostRelevant() as $attribute) {
                                        $nameChainToCheck = $nameChainSubCollection . '[' . $attribute . ']';
                                        if (false === $this->requestNestedByString($nameChainToCheck, $request)) {
                                            $attributesCheck = false;
                                        }
                                    }
                                    if ($attributesCheck) {
                                        $parentCollection->add($subCollectionRelation->getData()->getData()); /** @todo add Interface maybe */
                                    }
                                } // else not implemented, because is existing should not be overwritten or existing twice
                            }
                        } else {
                            /** @todo have to implement remove */
                            if (method_exists($parentCollection, 'remove')) { /** @todo other approach maybe */
                                if ($subCollectionRelation->getData() instanceof NotMatchedData) {
                                    // nothing to change
                                    // if not in request existing and before it was not on/enabled
                                } else {
                                    $parentCollection->remove($subCollectionRelation->getData());
                                }
                            }
                        }
                    }
                    continue; /** @todo bad approach here */
                }
                if (!is_null($component->getTransformer())) {
                    if (false !== $this->requestNestedByString($identifier, $request)) {
                        $requestValue = $this->requestNestedByString($identifier, $request);
                        $transformerClass = $component->getTransformer();
                        $transformer = new $transformerClass();
                        $newData = $transformer->toObj($requestValue, $component); /** @todo implement interface */
                        $component->forceData($newData);    
                    }
                } else {
                    $type = $component->getHtmlType();
                    $data = $component->getData();
                    $value = $type->getValue();
                    if (false !== $this->requestNestedByString($identifier, $request)) {
                        $valueFromRequest = $this->requestNestedByString($identifier, $request);
                        if ($value !== $valueFromRequest) {
                            $value = $valueFromRequest;
                            foreach ($component->getAttributes() as $attribute) {
                                $setMethod = 'set' . ucfirst($attribute);
                                if (method_exists($data, $setMethod)) {
                                    $data->$setMethod($value);
                                }
                            }
                        }
                    }
                }
            }
            if (!empty($setLater)) {
                if (isset($setLater[$identifier])) {
                    $nestedRelation = $setLater[$identifier]['nestedRelation'];
                    if ($nestedRelation instanceof NestedBuilderRelation) {
                        $setMethod = 'set' . ucfirst($nestedRelation->getIdentifier());
                        $data = $setLater[$identifier]['data'];
                        if ($data instanceof RequestDataBind) {
                            $componentToSet = $data->getData();
                            if ($component instanceof RequestDataBind) {
                                $data = $component->getData();
                                $componentToSet->$setMethod($data);
                            }
                        }
                    }
                    unset($setLater[$identifier]);
                }
            }
        }
    }

    /**
     * @param string $identifier
     * @param array $request
     * @return mixed
     */
    private function requestNestedByString($identifier, $request)
    {
        $identifier = str_replace(']', '', $identifier);
        $explodedIdentifiers = explode('[', $identifier);
        return $this->requestNestedByStrongLoop($explodedIdentifiers, $request);
    }

    /**
     * @param $identifierArray
     * @param $request
     * @return bool
     */
    private function requestNestedByStrongLoop($identifierArray, &$request)
    {
        $nextIdentifier = array_shift($identifierArray);
        if (!isset($request[$nextIdentifier])) {
            return false;
        } else {
            if (empty($identifierArray)) {
                return $request[$nextIdentifier];
            } else {
                return $this->requestNestedByStrongLoop($identifierArray, $request[$nextIdentifier]);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return Resolver
     */
    public function getResolver()
    {
        return $this->resolver;
    }
}