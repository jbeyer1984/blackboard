<?php


namespace src\App\Login\Form\Factory;

use src\App\Login\Configuration\LoginData;
use src\App\Login\Entity\LoginEntity;
use src\App\Login\Form\Type\LoginType;
use src\App\Login\Handler\LoginFormHandler;
use src\App\Login\Handler\Validator\PasswordStringValidator;
use src\Core\Form\Creator\FormCreator;
use src\Router\Request\Request;

class FormHandlerFactory
{
    /**
     * @var Request
     */
    private $request;

    /**
     * FormHandlerFactory constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param Request $request
     * @return LoginFormHandler
     */
    public function getCreatedLoginFormHandler(Request $request)
    {
        $self = new self($request);
        $loginFormHandler = $self->createLoginFormHandler();

        return $loginFormHandler;
    }

    /**
     * @return LoginFormHandler
     */
    private function createLoginFormHandler()
    {
        $passwordStringValidator = new PasswordStringValidator('false', 'true');
        if (!is_null($this->request->getPost()->get('login', null))) {
            $loginEntity = $this->createLoginEntity($this->request);

            $loginData = $this->createLoginData();
            $passwordStringValidator = new PasswordStringValidator(
                $loginEntity->getPassword(),
                $loginData->getPassword()
            );
        }
        $loginFormHandler = new LoginFormHandler($passwordStringValidator);

        return $loginFormHandler;
    }

    /**
     * @param Request $request
     * @return LoginEntity
     */
    private function createLoginEntity(Request $request)
    {
        $loginEntity = new LoginEntity();
        $formCreator = new FormCreator(new LoginType(), $loginEntity);
        $formCreator->handleRequest($request);
        /** @var LoginEntity $loginEntity */
        $loginEntity = $formCreator->getData();

        return $loginEntity;
    }

    /**
     * @return LoginData
     */
    private function createLoginData()
    {
        return new LoginData();
    }
}