<?php

namespace src\Router;

use src\Core\DI\ServiceComponent;
use src\Utilities\Logger\MyLogger;
use src\Utilities\Service\BaseUtilities;

class _Router extends ServiceComponent
{
    /**
     * configure service
     * @return void
     */
    public function register()
    {
        $this->set(MyLogger::class);

        $this->set(BaseUtilities::class, [
            MyLogger::class
        ]);

        $this->set(Router::class, [
            BaseUtilities::class
        ]);
    }
}
