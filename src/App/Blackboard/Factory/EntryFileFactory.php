<?php


namespace src\App\Blackboard\Factory;


use src\App\Blackboard\Configuration\EntryFile;

class EntryFileFactory
{

    /**
     * @return EntryFile
     */
    public function getCreatedDefaultEntryFile()
    {
        $fileName = SRC_PATH // path to configuration file
            . DIRECTORY_SEPARATOR . 'App'
            . DIRECTORY_SEPARATOR . 'Blackboard'
            . DIRECTORY_SEPARATOR . 'Configuration'
            . DIRECTORY_SEPARATOR . 'configuration_blackboard.json'
        ;
        $entryFile = $this->createEntryFile($fileName);

        return $entryFile;
    }

    /**
     * @param string $fileName
     * @return EntryFile
     */
    private function createEntryFile($fileName)
    {
        $configurationData           = json_decode(file_get_contents($fileName), true);
        $entryFileJsonRelation = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonRelation'];
        $entryFileJsonData     = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonData'];

        $entryFile = new EntryFile($fileName, $entryFileJsonRelation, $entryFileJsonData);

        return $entryFile;
    }
    
    
}