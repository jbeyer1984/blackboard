<?php

namespace src\Utilities\Logger;

interface LoggerInterface{
    
    /**
     * @see MyLogger
     * @param $arg
     * @return void
     */
    public function log($arg, $identifier);
}
