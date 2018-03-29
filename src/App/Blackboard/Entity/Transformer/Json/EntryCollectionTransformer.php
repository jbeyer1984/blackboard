<?php


namespace src\App\Blackboard\Entity\Transformer\Json;


use src\App\Blackboard\Entity\DanceCollection;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\EntryCollection;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\PersonalEntity;

/**
 * is based on json from Blackboard Configuration
 * Class EntryCollectionTransformer
 * @package App\Blackboard\Entity\Transformer
 */
class EntryCollectionTransformer
{
    /**
     * @param array $data
     * @return EntryCollection
     */
    public function toObj($data)
    {
        $entryCollection = new EntryCollection();
        foreach ($data as $timeEntry) {
            $personalEntity = null;
            $personal = $timeEntry['personal'];
            $personalEntity = new PersonalEntity($personal['name']);
            $danceCollection = new DanceCollection();
            foreach ($timeEntry['dance'] as $danceCollectionEntry) {
                foreach ($danceCollectionEntry as $dance) {
                    $danceEntity = new DanceEntity($dance['dance'], $dance['experience']);
                    $danceCollection->add($danceEntity);
                }                
            }

            $entryEntity = new EntryEntity($timeEntry['id'], $timeEntry['time'], $personalEntity, $danceCollection);
            $entryCollection->add($entryEntity);
        }
        
        return $entryCollection;
    }

    /**
     * @param EntryCollection $entryCollection
     * @return array
     */
    public function toArray(EntryCollection $entryCollection)
    {
        return $entryCollection->toArray();
    }


}