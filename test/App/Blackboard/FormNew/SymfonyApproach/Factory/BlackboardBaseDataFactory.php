<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Factory;


use src\App\Blackboard\Factory\EntryFileFactory;
use test\App\Blackboard\BlackboardBaseDataFromJson;

class BlackboardBaseDataFactory
{
    /**
     * @return BlackboardBaseDataFromJson
     */
    public function getBlackboardBaseDataFromJson()
    {
        $blackboardBaseDataFromJson = $this->createBlackboardBaseDataFromJson();

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
        $factory = new EntryFileFactory();
        $entryFile = $factory->getCreatedDefaultEntryFile();

        return $entryFile;
    }
}