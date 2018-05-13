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

    public function get($identifier, $default = null)
    {
        if (!is_null($default)) {
            if (!isset($_SESSION[$identifier])) {
                return $default;           
            }
        }
        return $_SESSION[$identifier];
    }

    public function set($identifier, $value)
    {
        $_SESSION[$identifier] = $value;
    }
}