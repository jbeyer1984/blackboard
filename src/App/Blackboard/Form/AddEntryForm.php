<?php


namespace src\App\Blackboard\Form;


use src\App\Blackboard\Form\Collection\DanceFormCollection;
use src\App\Blackboard\Form\Components\DanceForm;
use src\Core\Form\CheckBox;
use src\Core\Form\SelectOption;
use src\Core\Form\SelectOptionCollection;
use src\Core\Form\SelectBox;
use src\Core\Form\TextField;


class AddEntryForm
{
    /**
     * @return EntryForm
     */
    public function getFormData()
    {
        $danceTypes = $this->getDanceTypes();
        $danceFormCollection = new DanceFormCollection();
        foreach ($danceTypes as $type) {
            $typeIdentifier = strtolower($type);
            $checkBoxOptionCollection = new SelectOptionCollection();
            foreach ($this->getExperience() as $experience) {
                $checkBoxOption = new SelectOption($typeIdentifier, $experience);
                $checkBoxOptionCollection->add($checkBoxOption);
            }
            $danceForm = new DanceForm(
                new CheckBox($type),
                new SelectBox('Erfahrung Jahre', $checkBoxOptionCollection)
            );
            $danceFormCollection->add($danceForm);
        }
        $entryForm = new EntryForm(
            null,
            null,
            new TextField('Name', 'name', null),
            $danceFormCollection
        );

        return $entryForm;
    }

    /**
     * @return array
     */
    public function getExperience()
    {
        $experience = [
            'totaler Anfänger',
            'Anfänger',
            'Fortgeschritten',
            'Fast Profi',
            'Profi'
        ];

        return $experience;
    }

    /**
     * @return array
     */
    public function getDanceTypes()
    {
        $danceTypes = [
            'Salsa',
            'Kizomba',
            'Bachata'
        ];

        return $danceTypes;
    }
}