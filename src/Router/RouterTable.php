<?php


namespace src\Router;


use src\Controller\Blackboard\BlackboardController;

class RouterTable
{
    public function getTable()
    {
        $table = [
            [
                'url' => 'show',
                'controller' => BlackboardController::class,
                'action' => 'showAction',
            ],
            [
                'url' => 'add',
                'controller' => BlackboardController::class,
                'action' => 'addAction',
//                'post' => 'personal/dance',
                'postParameter' => [
                    'personal',
                    'dance'
                ]
            ],
            [
                'url' => 'edit',
                'controller' => BlackboardController::class,
                'action' => 'editAction',
//                'get' => 'id',
                'getParameter' => [
                    'id'
                ],
            ],
            [
                'url' => 'store',
                'controller' => BlackboardController::class,
                'action' => 'storeAction',
                //                'post' => 'id/personal/dance',
                'postParameter' => [
                    'id',
                    'personal',
                    'dance'
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
//            [
//                'url' => 'task1/user',
//                'controller' => UserController::class,
//                'action' => 'indexAction',
//                'class' => User::class
//            ]
        ];
            
        return $table;
    }
}