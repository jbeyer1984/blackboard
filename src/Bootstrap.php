<?php

$rootPath = dirname(__DIR__);
$srcPath  = $rootPath . DIRECTORY_SEPARATOR . 'src';
$pubPath  = $rootPath . DIRECTORY_SEPARATOR . 'public';
$viewPath = $rootPath . DIRECTORY_SEPARATOR . 'view';

define('ROOT_PATH', $rootPath);
define('SRC_PATH', $srcPath);
define('PUB_PATH', $pubPath);
define('VIEW_PATH', $viewPath);
//define('TRACE_ON', true);

function __autoload($class)
{
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $parts = explode(DIRECTORY_SEPARATOR, $class);
    include_once(ROOT_PATH . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php');
//    @include_once(TEST_PATH . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . '.php');
}

$path = PUB_PATH
    . DIRECTORY_SEPARATOR . 'files'
    . DIRECTORY_SEPARATOR . 'blackboard_data'
    . DIRECTORY_SEPARATOR . 'InitBlackBoard.php';
include($path);
