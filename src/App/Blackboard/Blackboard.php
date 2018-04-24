<?php

namespace src\App\Blackboard;

use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class Blackboard
{
    /**
     * @var BaseUtilities
     */
    private $base;

    /**
     * Blackboard constructor.
     * @param BaseUtilities $base
     */
    public function __construct(BaseUtilities $base)
    {
        $this->base = $base;
    }

    public function show()
    {   
        $blackboardEntries = new BlackboardEntries($this->base);
        $entryCollection = $blackboardEntries->read();
        $form = $blackboardEntries->getAddForm();
        $html = $form->getRenderedForm();
        // empty entry
        
        $formData = $html;
        
        $viewPath = 'blackboard/show.php';
        $this->base->getTemplate()->getView($viewPath, [
            'formData' => $formData,
            'entries' => $entryCollection
        ]);
    }

    public function add(Request $request)
    {
        $blackboardEntries = new BlackboardEntries($this->base);
        $form = $blackboardEntries->getAddForm();
        $formCreator = $form->getFormCreator();
        $formCreator->handleRequest($request);
        $entryEntity = $formCreator->getData();
        $blackboardEntries->create($entryEntity);
        
        $this->base->getRouter()->redirect('/blackboard.php/show');
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $id = $request->getGet()->get('id');
        $blackboardEntries = new BlackboardEntries($this->base);
        $form = $blackboardEntries->getEditForm($id);
        $html = $form->getRenderedForm();
        
        $formData = $html;
        
        $viewPath = 'blackboard/edit.php';
        $this->base->getTemplate()->getView($viewPath, [
            'entryFormId' => $form->getFormCreator()->getData()->getId(),
            'formData' => $formData,
        ]);
    }

    public function store(Request $request)
    {
        $entry = $request->getPost()->get('entry');
        $entryId = $entry['id'];
        $blackboardEntries = new BlackboardEntries($this->base);
        $form = $blackboardEntries->getEditForm($entryId);
        $formCreator = $form->getFormCreator();
        $formCreator->handleRequest($request);
        $entryEntity = $formCreator->getData();
        $blackboardEntries->store($entryEntity);
        
        $this->base->getRouter()->redirect('/blackboard.php/edit/' . $entryId);
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->getGet()->get('id');
        $blackboardEntries = new BlackboardEntries($this->base);
        $blackboardEntries->delete($id);

        $this->base->getRouter()->redirect('/blackboard.php/show');
    }
}