<?php


namespace src\App\Blackboard\Entity\Transformer\Form;


use src\App\Blackboard\Entity\DanceCollection;
use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\EntryCollection;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\PersonalEntity;
use src\App\Blackboard\Form\EditEntryForm;

class EntryCollectionTransformer
{
    /**
     * @param EditEntryForm $editForm
     * @return EntryCollection
     */
    public function toObj(EditEntryForm $editForm)
    {
        $entryCollection = new EntryCollection();
        $formData = $editForm->getFormData();
        $personalEntity = null;
        $personal = $formData->getPersonal();
        $personalEntity = new PersonalEntity($personal->getLabel());
        $danceCollection = new DanceCollection();
        foreach ($formData->getDanceFormCollection()->getDanceFormArray() as $danceForm) {
            $danceEntity = new DanceEntity(
                $danceForm->getDanceType()->getLabel(),
                $danceForm->getDance()->getLabel()
            );
            $danceCollection->add($danceEntity);
        }

        $now         = (new \DateTime('NOW'))->format('Y-m-d H:i:s');
        $entryEntity = new EntryEntity($formData->getId(), $now, $personalEntity, $danceCollection);
        $entryCollection->add($entryEntity);

        return $entryCollection;
    }
}