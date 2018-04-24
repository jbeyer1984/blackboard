<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Matcher;


class NotMatchedData
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * NotMatchedData constructor.
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}