<?php

namespace src\Utilities\Service;

use src\Router\Router;
use src\Utilities\Logger\LoggerInterface;
use src\Utilities\Template;

class BaseUtilities
{
    /**
     * @var LoggerInterface 
     */
    private $logger;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Template
     */
    private $template;

    /**
     * BaseUtilities constructor.
     * @param LoggerInterface $logger
     * @param Router $router
     * @param Template $template
     */
    public function __construct(
        LoggerInterface $logger = null,
        Router $router = null,
        Template $template = null
    )
    {
        $this->logger   = $logger;
        $this->router   = $router;
        $this->template = $template;
    }


    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @return Template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
