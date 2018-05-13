<?php

namespace src\Core;

//use src\Container\Container;
use src\Core\DI\ServiceComponent;
use src\Router\Factory\RouterFactory;
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
        $routerFactory = new RouterFactory();
        $router = $routerFactory->getCreated();
        
        $this->set(MyLogger::class);
        $this->set(Template::class);

        $this->set(BaseUtilities::class, [
            MyLogger::class,
            $router,
            Template::class
        ]);
        
        $this->set(Session::class);
    }
}
