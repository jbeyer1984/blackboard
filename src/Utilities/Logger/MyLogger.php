<?php


namespace src\Utilities\Logger;


class MyLogger implements LoggerInterface
{
//    /**
//     * @param $args
//     * @return void
//     */
//    public function configure($args)
//    {
//        
//    }

    /**
     * @param mixed $arg
     * @param string $identifier
     */
    public function log($arg, $identifier = '')
    {
        $e = new \Exception();
        $trace = $e->getTrace();
        $entry = array_shift($trace);
//        if (0 < count($trace)) {
//            $entry = array_shift($trace);
//        }

        $dump = print_r($arg, true);
        
//        $dump = print_r($entry, true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $entry ***' . PHP_EOL . " = " . $dump . PHP_EOL);
//        $strToFind = 'htdocs/test/check/';
//        $strToFind = str_replace('/', DIRECTORY_SEPARATOR, $strToFind);
//        $htdocsPos = stripos($entry['file'], $strToFind);
//        $file = substr($entry['file'], $htdocsPos + strlen($strToFind));
//        $file = substr($entry['file'], $htdocsPos + strlen($strToFind));
        $file = str_replace(ROOT_PATH . DIRECTORY_SEPARATOR, '', $entry['file']);
        $file = str_replace(DIRECTORY_SEPARATOR, '/', $file);
//        $file = $entry['file'];
        
        $txt = <<<TXT

-$- in {$file}:{$entry['line']} in {$entry['function']}
*** {$identifier} ***
 = $dump
TXT;
        error_log($txt);
    }
}