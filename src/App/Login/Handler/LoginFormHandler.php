<?php


namespace src\App\Login\Handler;


use src\Core\Handler\ValidateInterface;

class LoginFormHandler implements ValidateInterface
{
    /**
     * @var ValidateInterface
     */
    private $validator;

    /**
     * LoginFormHandler constructor.
     * @param ValidateInterface $validator
     */
    public function __construct(ValidateInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $valid = $this->validator->validate();
        
        return $valid;
    }
}