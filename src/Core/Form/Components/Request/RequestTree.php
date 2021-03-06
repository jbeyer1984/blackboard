<?php


namespace src\Core\Form\Components\Request;


class RequestTree
{
    /**
     * @var array
     */
    private $postTree;

    public function add($identifier, $value)
    {
        $this->postTree[$identifier] = $value;
    }

    /**
     * @return array
     */
    public function getPostTree()
    {
        return $this->postTree;
    }
    
}