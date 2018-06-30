<?php


namespace src\Core\Form\Creator\Factory;


use src\Core\Form\Builder;
use src\Core\Form\Components\Provider\NestedRead\NestedOrderedComponents;
use src\Core\Form\Creator\Components\LookupSubFormRelation;
use src\Core\Form\Creator\Components\LookupSubFormRelation\LaterRelationCollection;

class LookupChildFormRelationFactory
{
    /**
     * @param Builder $builder
     * @param NestedOrderedComponents $nestedComponentSearcher
     * @return LookupSubFormRelation
     */
    public function getCreatedLookupSubFormRelation(
        Builder $builder,
        NestedOrderedComponents $nestedComponentSearcher
    )
    {
        $laterRelationCollection = new LaterRelationCollection();
        $lookupSubFormRelation = new LookupSubFormRelation(
            $builder, $nestedComponentSearcher,
            $laterRelationCollection
        );

        return $lookupSubFormRelation;
    }
}