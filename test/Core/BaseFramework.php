<?php


namespace test\Core;


use src\Core\_Core;
use src\Core\DI\Service;
use src\Utilities\Service\BaseUtilities;

class BaseFramework extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseUtilities
     */
    protected $base;

    public function __construct()
    {
        Service::get(_UnitCore::class);
        $this->base = Service::get(_Core::class)->getSingle(BaseUtilities::class);
        parent::__construct();
    }


}