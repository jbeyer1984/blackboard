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