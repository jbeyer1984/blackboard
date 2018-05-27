<?php


namespace src\Core\Form\Creator\Components;


use src\Core\Form\Builder;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedComponents;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\Form\Creator\Components\LookupSubFormRelation\LaterRelation;
use src\Core\Form\Creator\Components\LookupSubFormRelation\LaterRelationCollection;
use src\Core\Form\NestedBuilderRelation;

class LookupSubFormRelation
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var NestedOrderedComponents
     */
    private $nestedComponentSearcher;

    /**
     * @var LaterRelationCollection
     */
    private $laterRelationCollection;

    /**
     * LookupSubFormRelation constructor.
     * @param Builder $builder
     * @param NestedOrderedComponents $nestedComponentSearcher
     * @param LaterRelationCollection $laterRelationCollection
     */
    public function __construct(Builder $builder, NestedOrderedComponents $nestedComponentSearcher, LaterRelationCollection $laterRelationCollection)
    {
        $this->builder                 = $builder;
        $this->nestedComponentSearcher = $nestedComponentSearcher;
        $this->laterRelationCollection = $laterRelationCollection;
    }


    public function determine()
    {
        foreach ($this->builder->getRequestTree()->getPostTree() as $identifier => $component) {
            $components = $this->nestedComponentSearcher->getNestedComponentsByNamespace($identifier);
            // check nested child relation exists
            if (!empty($components)) {
                $this->handleRequestDataBind($component);
            }
        }
    }

    /**
     * @param $component
     */
    private function handleRequestDataBind($component)
    {
        if ($component instanceof RequestDataBind) {
            $builder = $component->getBuilder();
            if (!is_null($builder) && !is_null($builder->getNestedBuilderRelation())) {
                $this->addLaterRelation($component, $builder);
            }
        }
    }

    /**
     * @param RequestDataBind $component
     * @param Builder $builder
     */
    private function addLaterRelation($component, $builder)
    {
        foreach ($builder->getNestedBuilderRelation()->getChildrenIdentifiers() as $childRelationIdentifier) {
            // have to check because 2 same entries can exist because nested relation
            // do not decide between nestedType or IteratorType Nested
            // so there can be doubled relations
            if (!$this->laterRelationCollection->isExisting($childRelationIdentifier)) {
                $this->laterRelationCollection->add(
                    $childRelationIdentifier,
                    new LaterRelation(
                        $builder->getNestedBuilderRelation(),
                        $component
                    )
                );
            }
        }
    }

    /**
     * @param $identifier
     * @param RequestDataBind $component
     */
    public function changeData($identifier, $component)
    {
        if (!$this->laterRelationCollection->isExisting($identifier)) {
            return;
        };
//        $nestedRelation = $setLater[$identifier]['nestedRelation'];
        $this->changeRelationData($identifier, $component);
        $this->laterRelationCollection->remove($identifier);
    }

    /**
     * @param RequestDataBind $identifier
     * @param $component
     */
    private function changeRelationData($identifier, RequestDataBind $component)
    {
        $laterRelation  = $this->laterRelationCollection->get($identifier);
        $this->changeNestedRelationData($component, $laterRelation);
    }

    /**
     * @param RequestDataBind $component
     * @param LaterRelation $laterRelation
     */
    private function changeNestedRelationData(RequestDataBind $component, $laterRelation)
    {
        $nestedRelation = $laterRelation->getNestedRelation();
        if ($nestedRelation instanceof NestedBuilderRelation) {
            $setMethod = 'set' . ucfirst($nestedRelation->getIdentifier());
            $data      = $laterRelation->getData();
            if ($data instanceof RequestDataBind && $component instanceof RequestDataBind) {
                $componentToSet = $data->getData();
                $data = $component->getData();
                $componentToSet->$setMethod($data);
            }
        }
    }

    /**
     * @return LaterRelationCollection
     */
    public function getLaterRelationCollection()
    {
        return $this->laterRelationCollection;
    }

}