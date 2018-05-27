<?php


namespace src\Router;


use src\Controller\Blackboard\BlackboardController;
use src\Controller\Login\LoginController;
use src\Controller\OverviewController;

class RouterTable
{
    public function getTable()
    {
        $table = [
            [
                'url' => '/blackboard.php',
                'controller' => OverviewController::class,
                'action' => 'indexAction',
            ],
            [
                'url' => 'login/show',
                'controller' => LoginController::class,
                'action' => 'showAction',
            ],
            [
                'url' => 'login/login',
                'controller' => LoginController::class,
                'action' => 'loginAction',
                'postParameter' => [
                    'login',
                ]
            ],
            [
                'url' => 'show',
                'controller' => BlackboardController::class,
                'action' => 'showAction',
            ],
            [
                'url' => 'add',
                'controller' => BlackboardController::class,
                'action' => 'addAction',
                'postParameter' => [
                    'entry',
                ]
            ],
            [
                'url' => 'edit',
                'controller' => BlackboardController::class,
                'action' => 'editAction',
                'getParameter' => [
                    'id'
                ],
            ],
            [
                'url' => 'store',
                'controller' => BlackboardController::class,
                'action' => 'storeAction',
                'postParameter' => [
                    'entry',
                ]
            ],
            [
                'url' => 'delete',
                'controller' => BlackboardController::class,
                'action' => 'deleteAction',
                'getParameter' => [
                    'id',
                ]
            ],
        ];
            
        return $table;
    }
}