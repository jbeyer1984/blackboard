<?php


namespace src\App\Blackboard\Form\Iterator;


use IteratorAggregate;
use src\App\Blackboard\Entity\DanceEntityCollection;
use Traversable;

class DanceEntityCollectionIterator implements IteratorAggregate
{
    /**
     * @var DanceEntityCollection
     */
    private $data;

    /**
     * DanceEntityCollectionIterator constructor.
     * @param DanceEntityCollection $data
     */
    public function __construct(DanceEntityCollection $data)
    {
        $this->data = $data;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data->getCollection());
    }
}