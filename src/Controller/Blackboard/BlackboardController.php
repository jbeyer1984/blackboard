<?php

namespace src\Controller\Blackboard;

use src\App\Blackboard\Factory\BlackboardFactory;
use src\App\Login\Handler\LoginSessionHandler;
use src\Core\_Core;
use src\Core\Controller\PreCheck;
use src\Core\DI\Service;
use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class BlackboardController implements PreCheck
{
    /**
     * @return bool
     */
    public function preCheck()
    {
        $loginHandler = new LoginSessionHandler();
        if ($loginHandler->validate()) {
            return true;
        }
        
        /** @var BaseUtilities $base */
        $base = Service::get(_Core::class)->getSingle(BaseUtilities::class);
        $base->getRouter()->redirect('/blackboard.php/login/show');
        
        return false;
    }
    
    public function showAction(Request $request)
    {
//        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboardFactory = new BlackBoardFactory();
        $blackboard = $blackboardFactory->getCreatedBlackboard();
        $blackboard->show();
    }

    public function addAction(Request $request)
    {
//        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboardFactory = new BlackBoardFactory();
        $blackboard = $blackboardFactory->getCreatedBlackboard();
        $blackboard->add($request);
    }

    public function editAction(Request $request)
    {
//        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboardFactory = new BlackBoardFactory();
        $blackboard = $blackboardFactory->getCreatedBlackboard();
        $blackboard->edit($request);
    }

    public function storeAction(Request $request)
    {
//        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboardFactory = new BlackBoardFactory();
        $blackboard = $blackboardFactory->getCreatedBlackboard();
        $blackboard->store($request);
    }

    public function deleteAction(Request $request)
    {
//        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboardFactory = new BlackBoardFactory();
        $blackboard = $blackboardFactory->getCreatedBlackboard();
        $blackboard->delete($request);
    }
}
