<?php

namespace src\Controller\Blackboard;

use src\App\Blackboard\Blackboard;
use src\Core\_Core;
use src\Core\DI\Service;
use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class BlackboardController
{
    public function showAction(Request $request)
    {
        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboard->show();
    }

    public function addAction(Request $request)
    {
        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboard->add($request);
    }

    public function editAction(Request $request)
    {
        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboard->edit($request);
    }

    public function storeAction(Request $request)
    {
        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboard->store($request);
    }

    public function deleteAction(Request $request)
    {
        $blackboard = new Blackboard(Service::get(_Core::class)->getSingle(BaseUtilities::class));
        $blackboard->delete($request);
    }
}
