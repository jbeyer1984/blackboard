<?php


namespace src\App\Login;


use src\App\Login\Form\Factory\FormHandlerFactory;
use src\App\Login\Form\LoginForm;
use src\App\Login\Handler\LoginSessionHandler;
use src\Core\Factory\BaseUtilitiesFactory;
use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class Login
{
    /**
     * @var BaseUtilities
     */
    private $base;
    
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->base = BaseUtilitiesFactory::getCreatedBaseUtilities();
    }

    public function show()
    {
        $loginForm = new LoginForm();
        
        $html = $loginForm->getRenderedForm();
        
        $viewPath = 'login/show.php';
        $this->base->getTemplate()->getView($viewPath, [
            'formData' => $html,
        ]);
    }
    
    public function login(Request $request)
    {
        $loginHandler = new LoginSessionHandler();
        $valid = $loginHandler->validate();

        if ($valid) {
            $this->base->getRouter()->redirect('/blackboard.php/show');
        } else {
            $loginFormHandler = FormHandlerFactory::getCreatedLoginFormHandler($request);
            $valid = $loginFormHandler->validate();
            if ($valid) {
                $loginHandler->write();
                $this->base->getRouter()->redirect('/blackboard.php/show');
            } else {
                $this->base->getRouter()->redirect('/blackboard.php/login/show');
            }
        }
    }
}