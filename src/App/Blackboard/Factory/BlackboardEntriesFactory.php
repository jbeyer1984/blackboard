<?php


namespace src\App\Blackboard\Factory;


use src\App\Blackboard\BlackboardEntries;
use src\App\Blackboard\Configuration\EntryFile;
use src\App\Blackboard\Entity\Transformer\Json\EntryCollectionTransformer;

class BlackboardEntriesFactory
{
    /**
     * @var BlackboardEntries
     */
    private $blackboardEntries;

    /**
     * @return BlackboardEntries
     */
    public function getCreated()
    {
        if (is_null($this->blackboardEntries)) {
            $entryFile = $this->createEntryFile();
            $jsonEntryCollectionTransformer = $this->createJsonEntryCollectionTransformer();
            $this->blackboardEntries = new BlackboardEntries($entryFile, $jsonEntryCollectionTransformer);
        }
        
        return $this->blackboardEntries;
    }

    /**
     * @return EntryFile
     */
    private function createEntryFile()
    {
        $entryFile = EntryFileFactory::getCreatedDefaultEntryFile();
        
        return $entryFile;
    }

    /**
     * @return EntryCollectionTransformer
     */
    private function createJsonEntryCollectionTransformer()
    {
        $jsonEntryCollectionTransformer = new EntryCollectionTransformer();
        
        return $jsonEntryCollectionTransformer;
    }
}