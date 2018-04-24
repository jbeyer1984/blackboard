<?php


namespace test\Core\Stub;


use src\Router\Router;
use src\Utilities\Template;

class StubComponent extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Template
     */
    private $template;

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    protected function init()
    {
        $this->router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        ;

        $this->template = $this->getMockBuilder(Template::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();
        ;
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