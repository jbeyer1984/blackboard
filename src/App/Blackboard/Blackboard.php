<?php

namespace src\App\Blackboard;

use src\App\Blackboard\Factory\BlackboardBaseDataFactory;
use src\Core\Utitlity\UrlHelper;
use src\Router\Request\Request;
use src\Utilities\Service\BaseUtilities;

class Blackboard
{
    /**
     * @var BaseUtilities
     */
    private $base;

    /**
     * @var BlackboardEntries
     */
    private $blackboardEntries;

    /**
     * Blackboard constructor.
     * @param BaseUtilities $base
     * @param BlackboardEntries $blackboardEntries
     */
    public function __construct(BaseUtilities $base, BlackboardEntries $blackboardEntries)
    {
        $this->base              = $base;
        $this->blackboardEntries = $blackboardEntries;
    }



//    /**
//     * Blackboard constructor.
//     * @param BaseUtilities $base
//     */
//    public function __construct(BaseUtilities $base)
//    {
//        $this->base = $base;
//    }

    public function show()
    {
        $factory = new BlackboardBaseDataFactory();
        $blackboardBaseData = $factory->getBlackboardBaseDataFromJson();
        $danceEntityCollection = $blackboardBaseData
            ->getDanceEntityCollection()
        ;
        $entryCollection = $this->blackboardEntries->read();
        $form = $this->blackboardEntries->getAddForm();
        $html = $form->getRenderedForm();
        // empty entry
        
        $formData = $html;
        
        $viewPath = 'blackboard/show.php';
        $this->base->getTemplate()->getView($viewPath, [
            'formData' => $formData,
            'danceEntityCollection' => $danceEntityCollection,
            'entries' => $entryCollection
        ]);
    }

    public function add(Request $request)
    {
        $form = $this->blackboardEntries->getAddForm();
        $formCreator = $form->getFormCreator();
        $formCreator->handleRequest($request);
        $entryEntity = $formCreator->getData();
        $this->blackboardEntries->create($entryEntity);
        
        $this->base->getRouter()->redirect('/blackboard.php/show');
    }

    /**
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->getGet()->get('id');
        $form = $this->blackboardEntries->getEditForm($id);
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
        $form = $this->blackboardEntries->getEditForm($entryId);
        $formCreator = $form->getFormCreator();
        $formCreator->handleRequest($request);
        $entryEntity = $formCreator->getData();
        $this->blackboardEntries->store($entryEntity);
        $editUrl = UrlHelper::getCreatedUrl(
            '/blackboard.php/edit',
            ['id' => $entryId]
        );
        $this->base->getRouter()->redirect($editUrl);
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->getGet()->get('id');
        $this->blackboardEntries->delete($id);

        $this->base->getRouter()->redirect('/blackboard.php/show');
    }
}