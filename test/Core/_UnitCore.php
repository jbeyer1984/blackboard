<?php


namespace test\Core;


use src\Core\_Core;
use src\Core\DI\Service;
use src\Core\DI\ServiceComponent;
use src\Router\_Router;
use src\Router\Router;
use src\Utilities\Logger\MyLogger;
use src\Utilities\Template;
use test\Core\Stub\StubComponent;

class _UnitCore extends ServiceComponent
{

    /**
     * configure service
     * @return void
     */
    public function register()
    {
        $stubComponent = new StubComponent();
        $routerService = Service::get(_Router::class);
        $routerService->inject(Router::class, $stubComponent->getRouter());
        
        $path = '/home/jbeyer/error.log';
        Service::get(_Core::class)->overwrite(MyLogger::class, [$path]);
        Service::get(_Core::class)->inject(Template::class, $stubComponent->getTemplate());

//        $this->set(Session::class);
    }
}