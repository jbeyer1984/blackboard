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

        $router = $routerService->getSingle(Router::class);
//        $this->set(MyLogger::class, ['']);
        $this->set(MyLogger::class);
        $this->set(Template::class);

        $this->set(BaseUtilities::class, [
            MyLogger::class,
            $router,
            Template::class
        ]);
        
//        $this->inject(Db::class, Container::getInstance()->getDb());
        
        $this->set(Session::class);
    }
}
