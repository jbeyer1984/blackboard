<?php


namespace src\App\Login\Handler\Validator;


use src\App\Login\_Login;
use src\App\Login\Configuration\LoginData;
use src\Core\_Core;
use src\Core\DI\Service;
use src\Core\Handler\ValidateInterface;
use src\Utilities\Session;

class PasswordSessionValidator implements ValidateInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var LoginData
     */
    private $loginData;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->session = Service::get(_Core::class)->getSingle(Session::class);
        $this->loginData = Service::get(_Login::class)->getSingle(LoginData::class);
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $valid = true;
        $password = $this->loginData->getPassword();
        
        if ($password !== $this->session->get('password', '')) {
            $valid = false;
        }
        
        return $valid;
    }
    
}