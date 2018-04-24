<?php


namespace src\App\Blackboard;


use src\App\Blackboard\Configuration\EntryFile;
use src\App\Blackboard\Entity\EntryEntity;
use src\App\Blackboard\Entity\Transformer\Json\EntryCollectionTransformer AS JsonEntryCollectionTransformer;
use src\App\Blackboard\Entity\EntryCollection;
use src\App\Blackboard\Form\AddEntryForm;
use src\App\Blackboard\Form\EditEntryForm;
use src\Core\DI\Service;
use src\Utilities\Service\BaseUtilities;

class BlackboardEntries
{
    /**
     * @var BaseUtilities
     */
    private $base;

    /**
     * @var EntryFile
     */
    private $entryFile;

    /**
     * @var JsonEntryCollectionTransformer
     */
    private $jsonTransformer;

    /**
     * BlackboardEntries constructor.
     * @param BaseUtilities $base
     */
    public function __construct(BaseUtilities $base)
    {
        $this->base = $base;
        
        $this->init();
    }

    protected function init()
    {
        $this->entryFile       = Service::get(_Blackboard::class)->getSingle(EntryFile::class);
        $this->jsonTransformer = Service::get(_Blackboard::class)->getSingle(JsonEntryCollectionTransformer::class);
    }

    /**
     * @return EntryCollection
     */
    public function read()
    {
        $data = $this->entryFile->readRelation();
        
        $entryCollection = $this->jsonTransformer->toObj($data);
        
        return $entryCollection;
    }

    /**
     * @param EntryEntity $entryEntity
     */
    public function create($entryEntity)
    {
        $existingData = $this->entryFile->readRelation();
        $newEntryEntity = $entryEntity->createActual();
        
        $existingData[$newEntryEntity->getId()] = $newEntryEntity->toArray();

        $this->entryFile->storeRelation($existingData);
    }

    /**
     * @return AddEntryForm
     */
    public function getAddForm()
    {
        $form = new AddEntryForm();
        
        return $form;
    }

    /**
     * @param int $id
     * @return EditEntryForm|null
     */
    public function getEditForm($id)
    {
        $entryCollection = $this->read();
        $entryForm = null;
        $editEntryForm = null;
        foreach ($entryCollection->getCollection() as $entryEntity) {
            if ($id == $entryEntity->getId()) {
                $editEntryForm = new EditEntryForm($entryEntity);
            }
        }
        
        return $editEntryForm;
    }

    /**
     * @param EntryEntity $entryEntity
     */
    public function store($entryEntity)
    {
        $existingData = $this->entryFile->readRelation();

        $existingData[$entryEntity->getId()] = $entryEntity->toArray();

        $this->entryFile->storeRelation($existingData);
    }
    
    /**
     * @param int $id
     */
    public function delete($id)
    {
        $existingData = $this->entryFile->readRelation();
        if (isset($existingData[$id])) {
            unset($existingData[$id]);
        }
        
        $this->entryFile->storeRelation($existingData);
    }
}