<?php

namespace src\Router;

use src\Core\Controller\PreCheck;
use src\Router\Request\Request;

class Router
{
    /**
     * @var string
     */
    private $lookup;

    /**
     * @var Request
     */
    private $request;

    /**
     * Router constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init();
    }

    protected function init()
    {
        $this->determine();
    }

    protected function determine()
    {
        $url = $_SERVER['REQUEST_URI'];
        
        $afterIndexPhp = str_replace(
            [
                '/' . 'test' . '/' . 'check',
                '/' . 'blackboard.php' . '/'
            ]
            , '', $url
        );
        
        if (empty($afterIndexPhp)) {
            echo 'this is index page';
        }
        
        $this->lookup = $afterIndexPhp;
    }

    public function route()
    {
        $routerTable = new RouterTable();
        $table = $routerTable->getTable();
        
        foreach ($table as $entry) {
            if (0 === stripos($this->lookup, $entry['url'])) {
                $controllerName = $entry['controller']; // no injection at moment
                $action = $entry['action'];
                
                $afterIndex = str_replace($entry['url'], '', $this->lookup);
                $afterIndex = substr($afterIndex, 1);
                if (empty($afterIndex)) {
                    $controllerName = $entry['controller']; // no injection at moment
                    $action = $entry['action'];
                } else {
//                    $afterIndexArgs = explode('/', $afterIndex);
//                    $args = $this->checkRequest($entry, $afterIndexArgs);
//                    
//                    if (empty($args)) {
//                        $errorMessage = <<<TXT
//url {$entry['url']} is wrong defined, context args
//TXT;
//                        throw new \Exception($errorMessage);       
//                    }
                }
                
//                $dump = print_r($controllerName, true);
//                error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $controllerName ***' . PHP_EOL . " = " . $dump . PHP_EOL);
    
                $class = new $controllerName();

                if ($class instanceof PreCheck) {
                    $class->preCheck();
                }
                
//                $request = $this->getDeterminedRequest($entry, $afterIndex);
                $request = $this->getDeterminedRequest();
                call_user_func_array([$class, $action], [$request]);
                
                break;
            }
        }
    }

    public function redirect($viewUrl)
    {
        header("Location: " . $viewUrl);
    }

//    /**
//     * @param array $entry
//     * @param $afterIndexArgs
//     * @return array
//     * @throws \Exception
//     */
//    private function checkRequest($entry, $afterIndexArgs)
//    {
//        $parameterToCheck = '';
//
//        if (isset($entry['get'])) {
//            $parameterToCheck = $entry['get'];
//
//        } elseif (isset($entry['post'])) {
//            $parameterToCheck = $entry['post'];
//        }
//        
//        $exploded = explode('/', $parameterToCheck);
//        if (count($afterIndexArgs) == count($exploded)) {
//            $args = $exploded;
//        } else {
//            $errorMessage = <<<TXT
//url: {$_SERVER['url']}, there may exist interfere route or wrong route or duplicated
//TXT;
//            throw new \Exception($errorMessage);
//        }
//        
//        return $args;
//    }

    private function getDeterminedRequest()
    {
        
        $request = $this->request;
//        if (isset($entry['getParameter'])) {
//            $values = explode('/', $afterIndex);
//            foreach ($entry['getParameter'] as $index => $identifier) {
//                $request->getGet()->add($identifier, $values[$index]);
//            }
//        } elseif (isset($entry['postParameter'])) {
//            foreach ($entry['postParameter'] as $identifier) {
//                $request->getPost()->add($identifier, $_POST[$identifier]);
//            }
//        }
        
        return $request;
    }
}