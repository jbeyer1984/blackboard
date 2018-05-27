<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post;

use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentSubCollectionBind;
use src\Core\Form\Components\Request\RequestDataBind;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;

class DanceEntityCollectionTransformer implements TransformerInterface
{
    /**
     * @param mixed $requestVal
     * @param RequestDataBind $bind
     * @return DanceEntityCollection
     */
    public function toObj($requestVal, RequestDataBind $bind = null)
    {
        foreach ($requestVal as $index => $entry) {
            if (empty($entry['name'])) {
                $data = $bind->getData();
                if ($data instanceof ParentSubCollectionBind) {
                    $parentSubCollectionBind = $data;
                    $collection = $parentSubCollectionBind->getParentCollection();
                    $entryToRemove = $collection->getCollection()[$index];
                    if (method_exists($collection, 'remove')) {
                        $collection->remove($entryToRemove);
                    }
                }
            }
        }
    }
}