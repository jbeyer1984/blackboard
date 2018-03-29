<?php


namespace src\App\Blackboard\Entity\Transformer\Post;


use src\App\Blackboard\Entity\DanceCollection;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\PersonalEntity;

class EntryCollectionTransformer
{
    /**
     * @param int $id
     * @param array $personalPost
     * @param array $dancePost
     * @return EntryEntity
     */
    public function toObj($id, $personalPost, $dancePost)
    {
        $personalEntity = new PersonalEntity($personalPost['name']);

        $danceCollection = new DanceCollection();
        foreach ($dancePost as $danceEntry) {

            if (isset($danceEntry['type']) && 'on' === $danceEntry['type']) {
                $danceEntity = new DanceEntity($danceEntry['dance'], $danceEntry['experience']);
                $danceCollection->add($danceEntity);
            }
        }
        $now         = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $entryEntity = new EntryEntity($id, $now, $personalEntity, $danceCollection);

        return $entryEntity;
    }
}