<?php


namespace src\App\Blackboard\Factory;


use src\App\Blackboard\Configuration\EntryFile;

class EntryFileFactory
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @return EntryFile
     */
    public static function getCreatedDefaultEntryFile()
    {
        $fileName = SRC_PATH // path to configuration file
            . DIRECTORY_SEPARATOR . 'App'
            . DIRECTORY_SEPARATOR . 'Blackboard'
            . DIRECTORY_SEPARATOR . 'Configuration'
            . DIRECTORY_SEPARATOR . 'configuration_blackboard.json'
        ;
        $self = new self($fileName);
        $entryFile = $self->createEntryFile();

        return $entryFile;
    }

    /**
     * EntryFileFactory constructor.
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return EntryFile
     */
    private function createEntryFile()
    {
        $fileName = $this->fileName;
        $configurationData           = json_decode(file_get_contents($fileName), true);
        $entryFileJsonRelation = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonRelation'];
        $entryFileJsonData     = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonData'];

        $entryFile = new EntryFile($fileName, $entryFileJsonRelation, $entryFileJsonData);

        return $entryFile;
    }
    
    
}