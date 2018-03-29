<?php

namespace src\Router;

use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class Router
{
    /**
     * @var BaseUtilities
     */
    private $base;
    
    /**
     * @var string
     */
    private $lookup;
    
    
    public function __construct(BaseUtilities $baseUtilities)
    {
        $this->base = $baseUtilities;
        
        $this->init();
    }

    protected function init()
    {
        $this->determine();
    }

    protected function determine()
    {
        $url = $_SERVER['REQUEST_URI'];
        
//        $this->base->getLogger()->log($url, '$url');

        $afterIndexPhp = str_replace(
            [
//                $docRoot,
                '/' . 'test' . '/' . 'check',
//                '/' . 'index.php' . '/'
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
                    $afterIndexArgs = explode('/', $afterIndex);
                    $args = $this->checkRequest($entry, $afterIndexArgs);
                    
                    if (empty($args)) {
                        $errorMessage = <<<TXT
url {$entry['url']} is wrong defined, context args
TXT;
                        throw new \Exception($errorMessage);       
                    }
                }
                
//                $dump = print_r($controllerName, true);
//                error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $controllerName ***' . PHP_EOL . " = " . $dump . PHP_EOL);
    
                $class = new $controllerName();
                
                $request = $this->getDeterminedRequest($entry, $afterIndex);
                call_user_func_array([$class, $action], [$request]);
            }
        }
    }

    public function redirect($viewUrl)
    {
        
        header("Location: " . $viewUrl);
//        die(0);
    }

    /**
     * @param array $entry
     * @param $afterIndexArgs
     * @return array
     * @throws \Exception
     */
    private function checkRequest($entry, $afterIndexArgs)
    {
        $parameterToCheck = '';

        if (isset($entry['get'])) {
            $parameterToCheck = $entry['get'];

        } elseif (isset($entry['post'])) {
            $parameterToCheck = $entry['post'];
        }
        
        $exploded = explode('/', $parameterToCheck);
        if (count($afterIndexArgs) == count($exploded)) {
            $args = $exploded;
        } else {
            $errorMessage = <<<TXT
url: {$_SERVER['url']}, there may exist interfere route or wrong route or duplicated
TXT;
            throw new \Exception($errorMessage);
        }
        
        return $args;

//        $this->base->getLogger()->log($_POST, '$_POST');
    }

    /**
     * @param array $entry
     * @param string $afterIndex
     * @return Request
     */
    private function getDeterminedRequest($entry, $afterIndex)
    {
        
        $request = new Request();
        if (isset($entry['getParameter'])) {
            $values = explode('/', $afterIndex);
            foreach ($entry['getParameter'] as $index => $identifier) {
                $request->getGet()->add($identifier, $values[$index]);
            }
        } elseif (isset($entry['postParameter'])) {
            foreach ($entry['postParameter'] as $identifier) {
                $request->getPost()->add($identifier, $_POST[$identifier]);
            }
        }
        
        return $request;
    }
}