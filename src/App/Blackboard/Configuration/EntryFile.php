<?php

namespace src\App\Blackboard\Configuration;

/**
 * this class read and store data
 * the configuration file is set in the Service _Blackboard
 * Class EntryFile
 * @package App\Blackboard\Configuration
 */
class EntryFile
{
    /**
     * @var string
     */
    private $configurationFile;

    /**
     * @var string
     */
    private $entryFileJsonRelation;

    /**
     * @var string
     */
    private $entryFileJsonData;

    /**
     * EntryFile constructor.
     * @param string $configurationFile
     * @param string $entryFileJsonRelation
     * @param string $entryFileJsonData
     */
    public function __construct($configurationFile, $entryFileJsonRelation, $entryFileJsonData)
    {
        $this->configurationFile     = $configurationFile;
        $this->entryFileJsonRelation = $entryFileJsonRelation;
        $this->entryFileJsonData     = $entryFileJsonData;
    }

    protected function init()
    {
        $configurationData           = json_decode(file_get_contents($this->configurationFile), true);
        $this->entryFileJsonRelation = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonRelation'];
        $this->entryFileJsonData     = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonData'];
    }

    public function readData()
    {
        $data = [];
        if (file_exists($this->entryFileJsonData)) {
            $data = json_decode(file_get_contents($this->entryFileJsonData), true);
        }

        return $data;
    }

    /**
     * return array
     */
    public function readRelation()
    {
        $data = [];
        if (file_exists($this->entryFileJsonRelation)) {
            $data = json_decode(file_get_contents($this->entryFileJsonRelation), true);
        }
        
        return $data;
    }

    /**
     * @param array $data
     */
    public function storeRelation($data)
    {
        file_put_contents($this->entryFileJsonRelation, json_encode($data, true));
    }

    /**
     * @param array $data
     */
    public function storeData($data)
    {
        file_put_contents($this->entryFileJsonData, json_encode($data, true));
    }
}

