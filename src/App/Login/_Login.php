<?php


namespace src\App\Login;


use src\App\Login\Configuration\LoginData;
use src\Core\DI\ServiceComponent;

class _Login extends ServiceComponent
{

    public function register()
    {
        $this->set(LoginData::class);
    }
}