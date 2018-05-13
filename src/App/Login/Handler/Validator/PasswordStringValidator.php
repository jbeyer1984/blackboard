<?php


namespace src\App\Login\Handler\Validator;


use src\App\Login\Configuration\LoginData;
use src\Core\Handler\ValidateInterface;

class PasswordStringValidator implements ValidateInterface
{
    /**
     * @var string
     */
    private $postPassword;

    /**
     * @var LoginData
     */
    private $password;

    /**
     * PasswordStringValidator constructor.
     * @param string $postPassword
     * @param string LoginData $password
     */
    public function __construct($postPassword, $password)
    {
        $this->postPassword = $postPassword;
        $this->password     = $password;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $valid = true;
        
        if (!password_verify($this->postPassword, $this->password)) {
            $valid = false;
        }
        
        return $valid;
    }
}