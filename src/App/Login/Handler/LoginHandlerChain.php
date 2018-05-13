<?php


namespace src\App\Login\Handler;


use src\Core\Handler\ValidateInterface;

class LoginHandlerChain implements ValidateInterface
{
    /**
     * @var LoginHandlerCollection
     */
    private $loginHandlerCollection;

    /**
     * LoginHandlerChain constructor.
     * @param LoginHandlerCollection $loginHandlerCollection
     */
    public function __construct(LoginHandlerCollection $loginHandlerCollection)
    {
        $this->loginHandlerCollection = $loginHandlerCollection;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $valid = true;
        foreach ($this->loginHandlerCollection->getCollection() as $validator) {
            if (!$validator->validate()) {
                $valid = false;
                break;
            }
        }
        
        return $valid;
    }
    
}