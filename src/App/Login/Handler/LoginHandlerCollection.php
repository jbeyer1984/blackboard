<?php


namespace src\App\Login\Handler;

use src\Core\Handler\ValidateInterface;

class LoginHandlerCollection
{
    /**
     * @var ValidateInterface[]
     */
    private $collection = [];

    public function add(ValidateInterface $validator)
    {
        $this->collection[] = $validator;
    }

    /**
     * @return ValidateInterface[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}