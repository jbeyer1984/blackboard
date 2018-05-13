<?php


namespace src\Controller\Login;


use src\App\Login\Login;
use src\Router\Request\Request;

class LoginController
{

    public function showAction()
    {
        $login = new Login();
        $login->show();
    }

    public function loginAction(Request $request)
    {
        $login = new Login();
        $login->login($request);
    }
}