<?php


namespace src\App\Blackboard\Factory;


use src\App\Blackboard\BlackboardBaseDataFromJson;

class BlackboardBaseDataFactory
{
    /**
     * @return BlackboardBaseDataFromJson
     */
    public static function getBlackboardBaseDataFromJson()
    {
        $blackboardBaseData = new self();
        $blackboardBaseDataFromJson = $blackboardBaseData->createBlackboardBaseDataFromJson();

        return $blackboardBaseDataFromJson;
    }

    /**
     * @return BlackboardBaseDataFromJson
     */
    private function createBlackboardBaseDataFromJson()
    {
        $entryFile = $this->createEntryFile();
        $blackboardBaseData = new BlackboardBaseDataFromJson($entryFile);

        return $blackboardBaseData;
    }

    /**
     * @return \src\App\Blackboard\Configuration\EntryFile
     */
    private function createEntryFile()
    {
        $entryFile = EntryFileFactory::getCreatedDefaultEntryFile();
        
        return $entryFile;
    }
}