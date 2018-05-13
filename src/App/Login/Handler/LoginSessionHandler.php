<?php


namespace src\App\Login\Handler;

use src\App\Login\_Login;
use src\App\Login\Configuration\LoginData;
use src\App\Login\Handler\Validator\PasswordSessionValidator;
use src\Core\_Core;
use src\Core\DI\Service;
use src\Core\Handler\ValidateInterface;
use src\Utilities\Session;

class LoginSessionHandler implements ValidateInterface
{
    /**
     * @var LoginData
     */
    private $loginData;
    
    /**
     * @var bool
     */
    private $isLoggedIn;

    /**
     * @var LoginHandlerChain
     */
    private $loginHandlerChain;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->loginData = Service::get(_Login::class)->getSingle(LoginData::class);
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $loginHandlerCollection = new LoginHandlerCollection();
        $loginHandlerCollection->add(new PasswordSessionValidator());
        $this->loginHandlerChain = new LoginHandlerChain($loginHandlerCollection);
        
        $valid = true;
        
        if (!$this->loginHandlerChain->validate()) {
            $valid = false;
        } 
        
        return $valid;
    }

    public function write()
    {
        /** @var Session $session */
        $session = Service::get(_Core::class)->getSingle(Session::class);
        $password = $this->loginData->getPassword();
        $session->set('password', $password);
    }

    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
}