<?php

namespace src\App\Blackboard;

use src\App\Blackboard\Configuration\EntryFile;
use src\App\Blackboard\Entity\Transformer\Json\EntryCollectionTransformer AS JsonEntryCollectionTransformer;
use src\Core\_Core;
use src\Core\DI\Service;
use src\Core\DI\ServiceComponent;
use src\Utilities\Service\BaseUtilities;

class _Blackboard extends ServiceComponent
{

    /**
     * configure service
     * @return void
     */
    public function register()
    {
        $baseUtilities = Service::get(_Core::class)->getSingle(BaseUtilities::class);
        $this->set(EntryFile::class, [
            $baseUtilities,
            SRC_PATH // path to configuration file
            . DIRECTORY_SEPARATOR . 'App'
            . DIRECTORY_SEPARATOR . 'Blackboard' 
            . DIRECTORY_SEPARATOR . 'Configuration'
            . DIRECTORY_SEPARATOR . 'configuration_blackboard.json' 
        ]);
        $this->set(JsonEntryCollectionTransformer::class);
        
        $this->set(BlackboardBaseDataFromJson::class, [$this->getSingle(EntryFile::class)]);
    }
}
