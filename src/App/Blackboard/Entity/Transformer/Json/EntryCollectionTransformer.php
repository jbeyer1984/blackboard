<?php


namespace src\App\Blackboard\Entity\Transformer\Json;


use src\App\Blackboard\Entity\DanceEntityCollection;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\EntryCollection;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\ExperienceEntity;
use src\App\Blackboard\Entity\ExperienceEntityCollection;
use src\App\Blackboard\Entity\PersonEntity;
use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Request\RequestDataBind;

/**
 * is based on json from Blackboard Configuration
 * Class EntryCollectionTransformer
 * @package App\Blackboard\EntityNew\Transformer
 */
class EntryCollectionTransformer implements TransformerInterface
{
    /**
     * @param array $data
     * @param RequestDataBind $requestDataBind
     * @return EntryCollection
     */
    public function toObj($data, RequestDataBind $requestDataBind = null)
    {
        $entryCollection = new EntryCollection();
        foreach ($data as $timeEntry) {
            $personalEntity = null;
            $person = $timeEntry['person'];
            $personalEntity = new PersonEntity($person['id'], $person['name'], $person['number'], $person['optional']);
            $danceCollection = new DanceEntityCollection();
            $danceEntry = $timeEntry['dance'];
            foreach ($danceEntry as $danceSubEntry) {
                $experienceEntry = $danceSubEntry['experience'];
                $experienceCollection = new ExperienceEntityCollection();
                foreach ($experienceEntry as $entry) {
                    $experienceCollection->add(new ExperienceEntity($entry['id'], $entry['name']));
                }
                $danceEntity = new DanceEntity($danceSubEntry['id'], $danceSubEntry['name'], $experienceCollection);
                $danceCollection->add($danceEntity);              
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