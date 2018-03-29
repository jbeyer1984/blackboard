<?php

namespace src\App\Blackboard\Form\Collection;

use src\App\Blackboard\Form\EntryForm;

class EntryFormCollection
{
    /**
     * @var EntryForm[]
     */
    private $entryFormArray = [];
    
    public function __construct()
    {
        
    }

    /**
     * @param EntryForm $entryForm
     */
    public function add(EntryForm $entryForm)
    {
        $this->entryFormArray[] = $entryForm;
    }

    /**
     * @return EntryForm[]
     */
    public function getEntryFormArray()
    {
        return $this->entryFormArray;
    }
}