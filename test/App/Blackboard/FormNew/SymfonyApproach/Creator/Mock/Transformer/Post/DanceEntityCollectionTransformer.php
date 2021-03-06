<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post;

use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation\ParentChildCollectionBind;
use src\Core\Form\Components\Request\RequestDataBind;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntity;
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
        $dump = print_r($requestVal, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $requestVal ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        $collection = null;
        foreach ($requestVal as $index => $entry) {
            if (empty($entry['name'])) {
                $data = $bind->getData();
                if ($data instanceof ParentChildCollectionBind) {
                    $parentSubCollectionBind = $data;
                    $collection = $parentSubCollectionBind->getParentCollection();
                    $idToRemove = $entry['id'];
                    $entryToRemove = null;
                    foreach ($collection->getCollection() as $entryDance) {
                        /** @var DanceEntity $entryDance */
                        if ($entryDance->getId() == $idToRemove) {
                            $entryToRemove = $entryDance;
                        }
                    }
                    if (!is_null($entryToRemove)) {
                        if (method_exists($collection, 'remove')) {
                            $collection->remove($entryToRemove);
                        }
                    }
                }
            }
        }

        return $collection;
    }
}