<?php

$rootPath = dirname(__DIR__);
$srcPath  = $rootPath . DIRECTORY_SEPARATOR . 'src';
$testPath  = $rootPath . DIRECTORY_SEPARATOR . 'test';
$pubPath  = $rootPath . DIRECTORY_SEPARATOR . 'public';
$viewPath = $rootPath . DIRECTORY_SEPARATOR . 'view';

define('ROOT_PATH', $rootPath);
define('SRC_PATH', $srcPath);
define('TEST_PATH', $testPath);
define('PUB_PATH', $pubPath);
define('VIEW_PATH', $viewPath);
//define('TRACE_ON', true);

include(ROOT_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
//function __autoload($class)
//{
//    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
//    $parts = explode(DIRECTORY_SEPARATOR, $class);
//    include_once(SRC_PATH . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php');
//}
