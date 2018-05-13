<?php

namespace src\App\Blackboard;

use src\App\Blackboard\Entity\Transformer\Json\EntryCollectionTransformer AS JsonEntryCollectionTransformer;
use src\Core\DI\ServiceComponent;

class _Blackboard extends ServiceComponent
{

    /**
     * configure service
     * @return void
     */
    public function register()
    {
//        $baseUtilities = Service::get(_Core::class)->getSingle(BaseUtilities::class);
//        $fileName = SRC_PATH // path to configuration file
//            . DIRECTORY_SEPARATOR . 'App'
//            . DIRECTORY_SEPARATOR . 'Blackboard'
//            . DIRECTORY_SEPARATOR . 'Configuration'
//            . DIRECTORY_SEPARATOR . 'configuration_blackboard.json'
//        ;
//        $configurationData           = json_decode(file_get_contents($fileName), true);
//        $entryFileJsonRelation = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonRelation'];
//        $entryFileJsonData     = ROOT_PATH . DIRECTORY_SEPARATOR . $configurationData['entryFileJsonData'];
//        $this->set(EntryFile::class, [
//            $fileName,
//            $entryFileJsonRelation,
//            $entryFileJsonData
//        ]);
//        $entryFile = EntryFileFactory::getCreatedDefaultEntryFile();
//        $this->inject(EntryFile::class, $entryFile);
        $this->set(JsonEntryCollectionTransformer::class);
        
//        $this->set(BlackboardBaseDataFromJson::class, [$this->getSingle(EntryFile::class)]);
    }
}
