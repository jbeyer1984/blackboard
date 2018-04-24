<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Choice;


use src\Core\Entity\CollectionInterface;

class SelectBoxOptionCollection implements CollectionInterface
{
    /**
     * @var SelectBoxOption[]
     */
    private $collection = [];

    public function add(SelectBoxOption $selectBoxOption)
    {
        $this->collection[] = $selectBoxOption;
    }

    /**
     * @return SelectBoxOption[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}