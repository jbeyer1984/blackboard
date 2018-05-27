<?php


namespace src\Router\Factory;


use src\Router\Request\Factory\RequestFactory;
use src\Router\Router;

class RouterFactory
{
    public function getCreated()
    {
        $router = $this->createRouter();
        
        return $router;
    }

    /**     * @return Router
     */
    private function createRouter()
    {
        $factory = new RequestFactory();
        $request = $factory->getCreatedRequest();

        $router = new Router($request);
        
        return $router;
    }
}