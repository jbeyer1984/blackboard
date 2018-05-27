<?php


namespace src\Core\Factory;


use src\Router\Factory\RouterFactory;
use src\Utilities\Logger\MyLogger;
use src\Utilities\Service\BaseUtilities;
use src\Utilities\Template;

class BaseUtilitiesFactory
{
    /**
     * @return BaseUtilities
     */
    public function getCreatedBaseUtilities()
    {
        $router = $this->createRouter();
        $logger = $this->createLogger();
        $template = $this->createTemplate();
        $baseUtilities = new BaseUtilities($logger, $router, $template);

        return $baseUtilities;
    }

    /**
     * @return \src\Router\Router
     */
    private function createRouter()
    {
        $routerFactory = new RouterFactory();
        $router = $routerFactory->getCreated();
        
        return $router;
    }

    /**
     * @return MyLogger
     */
    private function createLogger()
    {
        $logger = new MyLogger();
        
        return $logger;
    }

    private function createTemplate()
    {
        $template = new Template();
        
        return $template;
    }
}