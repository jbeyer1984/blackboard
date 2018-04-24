<?php


namespace src\Utilities\Logger;


class MyLogger implements LoggerInterface
{
    /**
     * @var string
     */
    private $path;

    public function __construct($path = '')
    {
        $this->path = $path;
    }

    /**
     * @param mixed $arg
     * @param string $identifier
     */
    public function log($arg, $identifier = '')
    {
        $e = new \Exception();
        $trace = $e->getTrace();
        $entry = array_shift($trace);

        $dump = print_r($arg, true);
        
        $file = str_replace(ROOT_PATH . DIRECTORY_SEPARATOR, '', $entry['file']);
        $file = str_replace(DIRECTORY_SEPARATOR, '/', $file);
//        $file = $entry['file'];
        
        $txt = <<<TXT

-$- in {$file}:{$entry['line']} in {$entry['function']}
*** {$identifier} ***
 = $dump
TXT;
        if (empty($this->path)) {
            error_log($txt);
        } else {
            error_log($txt, 3, $this->path);
        }
    }
}