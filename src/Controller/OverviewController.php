<?php


namespace src\Controller;


use src\App\Overview\Factory\OverviewFactory;
use src\Router\Request\Request;

class OverviewController
{
    public function indexAction(Request $request)
    {
        $overviewFactory = new OverviewFactory();
        $overview = $overviewFactory->getCreatedOverview();
        $overview->show();
    }
}