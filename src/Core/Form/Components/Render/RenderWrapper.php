<?php


namespace src\Core\Form\Components\Render;


use src\Core\Form\Builder;
use src\Core\Form\BuilderCollection;
use src\Core\Form\Components\Render\Components\Collection\TypeWrapperCollection;
use src\Core\Form\Components\Utility\NamespaceHelper;

class RenderWrapper
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var RenderWrapperComponentInterface[]
     */
    private $components = [];

    /**
     * @var TypeWrapperCollection
     */
    private $typeWrapperCollection;

    /**
     * @var array
     */
    private $contextStack = [];

    /**
     * @var RenderWrapperComponentInterface[]
     */
    private $componentStack = [];

    /**
     * RenderWrapper constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function add(RenderWrapperComponentInterface $component)
    {
        $this->components[] = $component;
    }

    /**
     * @param TypeWrapperCollection $wrapperCollection
     */
    public function injectTypeWrapper(TypeWrapperCollection $wrapperCollection)
    {
        $this->typeWrapperCollection = $wrapperCollection;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->getEntriesNestedRendered();
    }

    /**
     * @return string
     */
    public function getEntriesNestedRendered()
    {
        $html = $this->getEntriesMapLoopRendered($this->builder->getEntriesOrdered());
        if (!empty($this->componentStack)) {
            for ($i = count($this->componentStack) - 1; $i >= 0; $i--) {
                $component = $this->componentStack[$i];
                $html .= $component->renderEnd();
            }
        }
        return $html;
    }

    /**
     * @param $map
     * @return string
     */
    protected function getEntriesMapLoopRendered($map)
    {
        $html = '';
        foreach ($map as $index => $entry) {
            if ($entry instanceof Builder) {
                $html .= $this->getEntriesMapLoopRendered($entry->getEntriesOrdered());
            }
            if ($entry instanceof BuilderCollection) {
                $renderWrapper = null;
                foreach ($this->typeWrapperCollection->getCollection() as $wrapper) {
                    if (NamespaceHelper::getDeterminedNamespaceComparison(
                        $wrapper->getIdentifier(), $entry->getNamespace()
                    )) {
                        $renderWrapper = $wrapper;
                    }
                }
                foreach ($entry->getBuilderCollection() as $builder) {
                    if (!is_null($renderWrapper)) {
                        $html .= $renderWrapper->renderStart() . PHP_EOL;
                        $html .= $this->getEntriesMapLoopRendered($builder->getEntriesOrdered());
                        $html .= $renderWrapper->renderEnd() . PHP_EOL;    
                    } else {
                        $html .= $this->getEntriesMapLoopRendered($builder->getEntriesOrdered());
                    }
                }
            } else {
                $namespace = $entry->getIdentifier();

                $found = false;
//                if (!empty($this->componentStack) && empty($this->contextStack)) {
//                    $component = $this->componentStack[count($this->componentStack)-1];
//                    // check if component is matching
//                    $componentNamespace = $component->getIdentifier();
//                    $attributesCollection = $component->getOption()->getAttributes();
//                    foreach ($attributesCollection->getCollection() as $attributeString) {
//                        $namespaceTemp = <<<TXT
//{$componentNamespace}[{$attributeString}]
//TXT;
//                        // if stack is empty
//                        if (empty($this->contextStack)) {
//                            $namespaceToCut = $this->getDetermineNamespaceComparison($namespaceTemp, $namespace);
//                            if (false === stripos($namespaceToCut, '[') && false === stripos($namespaceToCut, ']')) {
//                                // got it
//                                $found = true;
//                                $html .= $component->renderStart();
//
//                                array_push($this->componentStack, $component);
//                                // push on stack $namespace - [$last]
//                                $explodedNamespace = explode('[', $namespace);
//                                array_pop($explodedNamespace);
//                                $implodedNamespace = implode('[', $explodedNamespace);
//                                $toStack = substr($implodedNamespace, -1);
//                                array_push($this->contextStack, $toStack);
//                            }
//                        }
//                    }
//                }

                if (!$found && !empty($this->componentStack)) {
                    $component = $this->componentStack[count($this->componentStack)-1];
                    // check if component is matching
                    $componentNamespace = $component->getIdentifier();
                    $attributesCollection = $component->getOption()->getAttributes();
                    foreach ($attributesCollection->getCollection() as $attributeString) {
                        $namespaceTemp = <<<TXT
{$componentNamespace}[{$attributeString}]
TXT;
                        // if stack is empty
                        if (!empty($this->contextStack)) {
                            // is stack not empty check nested is in stack
                            $namespaceToCut = $this->getDetermineNamespaceComparison($namespaceTemp, $namespace);
                            if (false === stripos($namespaceToCut, '[') && false === stripos($namespaceToCut, ']')) {
                                // got it

                                // if component found and last stack entry sub of found
                                $lastContext = $this->contextStack[count($this->componentStack)-1];
                                if (false !== stripos($namespace, $lastContext)) {
                                    // if not on stack
                                    $componentIdentifierArray = array_map(function ($component) {
                                        /** @var RenderWrapperComponentInterface $component */
                                        return $component->getIdentifier();
                                    }, $this->componentStack);
                                    if (!in_array($component->getIdentifier(), $componentIdentifierArray)) {
                                        // start render begin
                                        $found = true;
                                        $html .= $component->renderStart();

                                        array_push($this->componentStack, $component);
                                        // push on stack $namespace - [$last]
                                        $explodedNamespace = explode('[', $namespace);
                                        array_pop($explodedNamespace);
                                        $implodedNamespace = implode('[', $explodedNamespace);
                                        $toStack = substr(0, -1, $implodedNamespace);
                                        array_push($this->contextStack, $toStack);
                                    } else {
                                        $found = true;
                                    }
                                }

//                                if (!$found) {
//                                    /** @var RenderWrapperComponentInterface $lastComponent */
//                                    $lastComponent = array_pop($this->componentStack);
//                                    $html .= $lastComponent->renderEnd();
//                                    array_pop($this->contextStack);
//                                }
                            }
                        }
                    }
                    if (!$found) {
                        /** @var RenderWrapperComponentInterface $lastComponent */
                        $lastComponent = array_pop($this->componentStack);
                        $html          .= $lastComponent->renderEnd();
                        array_pop($this->contextStack);
                    }
                }


                // if component stack is empty
                if (!$found && empty($this->componentStack)) {
                    
                    foreach ($this->components as $component) {
                        $componentNamespace = $component->getIdentifier();
                        $attributesCollection = $component->getOption()->getAttributes();
                        foreach ($attributesCollection->getCollection() as $attributeString) {
                            $namespaceTemp = <<<TXT
{$componentNamespace}[{$attributeString}]
TXT;
                            // if stack is empty
                            if (empty($this->contextStack)) {
                                $namespaceToCut = $this->getDetermineNamespaceComparison($namespaceTemp, $namespace);
                                if (false === stripos($namespaceToCut, '[') && false === stripos($namespaceToCut, ']')) {
                                    // got it
                                    $html .= $component->renderStart();
                                    
                                    array_push($this->componentStack, $component);
                                    // push on stack $namespace - [$last]
                                    $explodedNamespace = explode('[', $namespace);
                                    array_pop($explodedNamespace);
                                    $implodedNamespace = implode('[', $explodedNamespace);
                                    $toStack = $implodedNamespace;
                                    array_push($this->contextStack, $toStack);
                                }
                            }
                        }
                    }
                }

//                if (false === $found) {
                    if (method_exists($entry, 'render')) {
                        $htmlToAdd = $entry->render();
                        if (!empty($htmlToAdd)) {
                            $html .= $entry->render() . PHP_EOL;
                        }
                    }
//                }
            }
        }

        return $html;
    }

    /**
     * @param $namespaceToSearch
     * @param $namespace
     * @return bool|mixed|string
     */
    protected function getDetermineNamespaceComparison($namespaceToSearch, $namespace)
    {
        $namespaceToCut = '[[';
        if (false === stripos($namespaceToSearch, '#')) {
            if ($namespaceToSearch == $namespace) {
                $namespaceToCut = '';
            }
        } else {
            $explodedToSearchUntilHash = explode('#', $namespaceToSearch);
            $namespaceToCut            = $namespace;
            $restFields                = [];
            foreach ($explodedToSearchUntilHash as $index => $withoutHash) {
                if (false !== stripos($namespaceToCut, $withoutHash)) {
                    $strPos = stripos($namespaceToCut, $withoutHash);
                    if (isset($explodedToSearchUntilHash[$index + 1])) {
                        $justCheck            = substr($namespaceToCut, $strPos + strlen($withoutHash));
                        $lookAheadWithoutHash = $explodedToSearchUntilHash[$index + 1];
                        $justCheckLooAheadPos = stripos($justCheck, $lookAheadWithoutHash);
                        $restFields[]         = substr(
                            $namespaceToCut,
                            $strPos + strlen($withoutHash),
                            $justCheckLooAheadPos
                        );
                        $namespaceToCut       = substr(
                            $namespaceToCut,
                            $strPos + strlen($withoutHash) + $justCheckLooAheadPos
                        );
                    } else {
                        $namespaceToCut = str_replace($withoutHash, '', $namespaceToCut);
                    }

                }
            }
        }

        return $namespaceToCut;
    }
}