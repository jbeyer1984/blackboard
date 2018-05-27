<?php


namespace src\App\Blackboard\Factory;


use src\App\Blackboard\Blackboard;
use src\Core\Factory\BaseUtilitiesFactory;
use src\Utilities\Service\BaseUtilities;

class BlackboardFactory
{
    /**
     * @var Blackboard
     */
    private $blackboard;

    /**
     * @return Blackboard
     */
    public function getCreatedBlackboard()
    {
        if (is_null($this->blackboard)) {
            
            $blackboardEntries = $this->createBlackboardEntries();
            $baseUtilities = $this->createBaseUtilities();
            $this->blackboard = new Blackboard($baseUtilities, $blackboardEntries);
        }

        return $this->blackboard;
    }

    /**
     * @return BaseUtilities
     */    
    private function createBaseUtilities()
    {
        $factory = new BaseUtilitiesFactory();
        $baseUtilities = $factory->getCreatedBaseUtilities();

        return $baseUtilities;
    }

    private function createBlackboardEntries()
    {
        $blackboardEntriesFactory = new BlackboardEntriesFactory();
        $blackboardEntries = $blackboardEntriesFactory->getCreated();
        
        return $blackboardEntries;
    }
}