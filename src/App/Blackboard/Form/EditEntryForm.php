<?php


namespace src\App\Blackboard\Form;


use src\App\Blackboard\Entity\DanceEntity;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Form\Collection\DanceFormCollection;
use src\App\Blackboard\Form\Components\DanceForm;
use src\Core\Form\CheckBox;
use src\Core\Form\SelectOption;
use src\Core\Form\SelectOptionCollection;
use src\Core\Form\SelectBox;
use src\Core\Form\TextField;

class EditEntryForm extends AddEntryForm
{
    /**
     * @var EntryEntity
     */
    private $entryEntity;

    /**
     * EditEntryForm constructor.
     * @param EntryEntity $entryEntity
     */
    public function __construct(EntryEntity $entryEntity)
    {
        $this->entryEntity = $entryEntity;
    }

    /**
     * @return EntryForm
     */
    public function getFormData()
    {
        $entryEntity = $this->entryEntity;
        $addEntryForm = new AddEntryForm();
        $danceFormCollection = new DanceFormCollection();
        $danceTypes =  $addEntryForm->getDanceTypes();
        
        $danceEntityLookup = [];
        foreach ($entryEntity->getDanceCollection()->getDanceArray() as $danceEntity) {
            $danceEntityLookup[$danceEntity->getDance()] = $danceEntity;
        }
        
        foreach ($danceTypes as $dance) {
            $danceIdentifier = strtolower($dance);
            $checkBoxOptionCollection = new SelectOptionCollection();
            if (!isset($danceEntityLookup[$dance]) ) {
                foreach ($addEntryForm->getExperience() as $experience) {
                    $checkBoxOption = new SelectOption($danceIdentifier, $experience);
                    $checkBoxOptionCollection->add($checkBoxOption);
                }
                $danceForm = new DanceForm(
                    new CheckBox($dance, $dance),
                    new SelectBox('Erfahrung Jahre', $checkBoxOptionCollection)
                );
            } else {
                /** @var DanceEntity $danceEntity */
                $danceEntity = $danceEntityLookup[$dance];
                foreach ($addEntryForm->getExperience() as $experience) {
                    if ($experience !== $danceEntity->getExperience()) {
                        $checkBoxOption = new SelectOption($danceIdentifier, $experience);
                    } else {
                        $checkBoxOption = new SelectOption($danceIdentifier, $experience, true);
                    }
                    $checkBoxOptionCollection->add($checkBoxOption);
                }
                $danceForm = new DanceForm(
                    new CheckBox($danceEntity->getDance(), $danceEntity->getDance(), true),
                    new SelectBox('Erfahrung Jahre', $checkBoxOptionCollection)
                );        
            }
            $danceFormCollection->add($danceForm);
        }
        $editEntryForm = new EntryForm(
            $entryEntity->getId(),
            $entryEntity->getTime(),
            new TextField(
                'Name',
                'name',
                $entryEntity->getPersonal()->getName()
            ),
            $danceFormCollection
        );

        return $editEntryForm;
    }
}