<?php

namespace src\App\Blackboard\Configuration;

use src\Utilities\Service\BaseUtilities;

/**
 * this class read and store data
 * the configuration file is set in the Service _Blackboard
 * Class EntryFile
 * @package App\Blackboard\Configuration
 */
class EntryFile
{
    /**
     * @see _Blackboard
     * @var BaseUtilities
     */
    private $base;
    
    /**
     * @var string
     */
    private $configurationFile;

    /**
     * @var string
     */
    private $entryFileJson;

    /**
     * EntryFile constructor.
     * @param BaseUtilities $base
     * @param $configurationFile
     */
    public function __construct(BaseUtilities $base, $configurationFile)
    {
        $this->base = $base;
        $this->configurationFile = $configurationFile;
        
        $this->init();
    }

    protected function init()
    {
        $configurationData = json_decode(file_get_contents($this->configurationFile), true);
        $this->entryFileJson = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJson'];
    }

    /**
     * return array
     */
    public function read()
    {
        $data = [];
        if (file_exists($this->entryFileJson)) {
            $data = json_decode(file_get_contents($this->entryFileJson), true);
        }
        
        return $data;
    }

    /**
     * @param array $data
     */
    public function store($data)
    {
        file_put_contents($this->entryFileJson, json_encode($data, true));
    }
}

