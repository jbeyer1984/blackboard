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
        $formData = $form->getFormData();
        
        $viewPath = 'blackboard/show.php';
        $this->base->getTemplate()->getView($viewPath, [
            'formData' => $formData,
            'entries' => $entryCollection
        ]);
    }

    public function add(Request $request)
    {
        $personal = $request->getPost()->get('personal');
        $dance = $request->getPost()->get('dance');
        
        
        $this->base->getLogger()->log($dance, '$dance');

        $blackboardEntries = new BlackboardEntries($this->base);
        $blackboardEntries->create($personal, $dance);
        
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
        $formData = $form->getFormData();
        
        $viewPath = 'blackboard/edit.php';
        $this->base->getTemplate()->getView($viewPath, [
            'formData' => $formData,
        ]);
    }

    public function store(Request $request)
    {
        $id = $request->getPost()->get('id');
        $personal = $request->getPost()->get('personal');
        $dance = $request->getPost()->get('dance');

        $blackboardEntries = new BlackboardEntries($this->base);
        $blackboardEntries->store($id, $personal, $dance);
        
        $this->base->getRouter()->redirect('/blackboard.php/edit/' . $id);
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