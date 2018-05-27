<?php


namespace src\App\Overview\Factory;


use src\App\Overview\Overview;
use src\Core\Factory\BaseUtilitiesFactory;

class OverviewFactory
{
    public function getCreatedOverview()
    {
        $baseUtilitiesFactory = new BaseUtilitiesFactory();
        return new Overview($baseUtilitiesFactory->getCreatedBaseUtilities());
    }
}