<?php

namespace src\Utilities\Logger;

interface LoggerInterface{
//    /**
//     * @param $args
//     * @return void
//     */
//    public function configure($args);
    
    /**
     * @param $arg
     * @return void
     */
    public function log($arg, $identifier);
}
