<?php

namespace src\Core;

//use src\Container\Container;
use src\Core\DI\Service;
use src\Core\DI\ServiceComponent;
use src\Router\_Router;
use src\Router\Router;
//use src\Utilities\Db;
use src\Utilities\Logger\MyLogger;
use src\Utilities\Service\BaseUtilities;
use src\Utilities\Session;
use src\Utilities\Template;

class _Core extends ServiceComponent
{
    /**
     * configure service
     * @return void
     */
    public function register()
    {
        $routerService = Service::get(_Router::class);

//        $dump = print_r($routerService->getTraceString(), true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $routerService->getTraceString() ***' . PHP_EOL . " = " . $dump . PHP_EOL);

        $router = $routerService->getSingle(Router::class);
//        $dump = print_r($router, true);
//        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $router ***' . PHP_EOL . " = " . $dump . PHP_EOL);
        $this->set(MyLogger::class);
        $this->set(Template::class);

        $this->set(BaseUtilities::class, [
            MyLogger::class,
            //            $routerService->getSingle(Router::class),
            $router,
            Template::class
        ]);
        
//        $this->inject(Db::class, Container::getInstance()->getDb());
        
        $this->set(Session::class);
    }
}
