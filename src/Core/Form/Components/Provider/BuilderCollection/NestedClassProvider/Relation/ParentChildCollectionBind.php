<?php


namespace src\Core\Form\Components\Provider\BuilderCollection\NestedClassProvider\Relation;


use src\Core\Entity\CollectionInterface;

class ParentChildCollectionBind
{
    /**
     * @var array
     */
    private $postRelevant;

    /**
     * @var CollectionInterface
     */
    private $parentCollection;

    /**
     * @var ChildRelationCollectionCollection
     */
    private $childRelationCollectionCollection;

    /**
     * ParentSubCollectionBind constructor.
     * @param array $addAttributes
     * @param CollectionInterface $parentCollection
     * @param ChildRelationCollectionCollection $childRelationCollectionCollection
     */
    public function __construct(
        array $addAttributes, CollectionInterface $parentCollection,
        ChildRelationCollectionCollection $childRelationCollectionCollection
    ) {
        $this->postRelevant                    = $addAttributes;
        $this->parentCollection                = $parentCollection;
        $cl = get_class($this->parentCollection);
        $dump = print_r($cl, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $cl ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        $this->childRelationCollectionCollection = $childRelationCollectionCollection;
        $clSub                                   = get_class($this->childRelationCollectionCollection);
        $dump                                    = print_r($clSub, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $clSub ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');

        foreach ($this->childRelationCollectionCollection->getCollection() as $subRelationCollection) {
            $subRel = get_class($subRelationCollection);
            $dump = print_r($subRel, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $subRel ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
            $nameChain = $subRelationCollection->getNameChain();
            $dump = print_r($nameChain, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $nameChain ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
            
            $data = $subRelationCollection->getData();
            $dump = print_r($data, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $data ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
            
        }
    }

    /**
     * @return array
     */
    public function getPostRelevant()
    {
        return $this->postRelevant;
    }

    /**
     * @return CollectionInterface
     */
    public function getParentCollection()
    {
        return $this->parentCollection;
    }

    /**
     * @return ChildRelationCollectionCollection
     */
    public function getChildRelationCollectionCollection()
    {
        return $this->childRelationCollectionCollection;
    }
}