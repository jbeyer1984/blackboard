<?php

namespace src\Utilities;

class Session
{   
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        session_start();
    }

    public function get($identifier)
    {
        return $_SESSION[$identifier];
    }

    public function set($identifier, $value)
    {
        $_SESSION[$identifier] = $value;
    }
}