<?php


namespace test\Utilities\Service;


use src\Router\Factory\RouterFactory;
use src\Router\Router;
use src\Utilities\Logger\MyLogger;
use src\Utilities\Service\BaseUtilities;
use src\Utilities\Template;

class BaseUtilitiesFactory extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseUtilities
     */
    private static $baseUtilities;

    /**
     * @return BaseUtilities
     */
    public static function getCreatedBaseUtilities()
    {
        if (is_null(self::$baseUtilities)) {
            $self = new self();
            self::$baseUtilities = $self->createBaseUtilities();
        }

        return self::$baseUtilities;
    }

    /**
     *
     */
    public function createBaseUtilities()
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
        $router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $router;
    }

    /**
     * @return MyLogger
     */
    private function createLogger()
    {
        $path = '/home/jbeyer/error.log';
        $logger = new MyLogger($path);

        return $logger;
    }

    /**
     * @return Template
     */
    private function createTemplate()
    {
        $template = $this->getMock(Template::class);

        return $template;
    }
}