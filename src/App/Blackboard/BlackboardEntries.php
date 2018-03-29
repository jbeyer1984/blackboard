<?php


namespace src\App\Blackboard;


use src\App\Blackboard\Configuration\EntryFile;
use src\App\Blackboard\Entity\EntryCollection;
use src\App\Blackboard\Entity\Transformer\Json\EntryCollectionTransformer AS JsonEntryCollectionTransformer;
use src\App\Blackboard\Entity\Transformer\Post\EntryCollectionTransformer AS PostEntryCollectionTransformer;
use src\App\Blackboard\Entity\Transformer\Form\EntryCollectionTransformer AS FormEntryCollectionTransformer;
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
     * @var PostEntryCollectionTransformer
     */
    private $postTransformer;

    /**
     * @var FormEntryCollectionTransformer
     */
    private $formTransformer;

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
        $this->postTransformer = Service::get(_Blackboard::class)->getSingle(PostEntryCollectionTransformer::class);
        $this->formTransformer = Service::get(_Blackboard::class)->getSingle(FormEntryCollectionTransformer::class);
    }

    /**
     * @return EntryCollection
     */
    public function read()
    {
        $data = $this->entryFile->read();
        
//        $this->base->getLogger()->log($data, '$data');
        
        $entryCollection = $this->jsonTransformer->toObj($data);
        
        return $entryCollection;
    }

    /**
     * @param $personalPost
     * @param $dancePost
     */
    public function create($personalPost, $dancePost)
    {
        $existingData = $this->entryFile->read();
        $nextId = count($existingData);
        $entryEntity = $this->postTransformer->toObj($nextId, $personalPost, $dancePost);
        $existingData[$nextId] = $entryEntity->toArray();

        $this->entryFile->store($existingData);
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
        foreach ($entryCollection->getEntryArray() as $entryEntity) {
            if ($id == $entryEntity->getId()) {
                $editEntryForm = new EditEntryForm($entryEntity);
            }
        }
        
        return $editEntryForm;
    }

    /**
     * @param int $id
     * @param array $personalPost
     * @param array $dancePost
     */
    public function store($id, $personalPost, $dancePost)
    {
        $dump = print_r($_POST, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $_POST ***' . PHP_EOL . " = " . $dump . PHP_EOL);
        
        $existingData = $this->entryFile->read();
        $entryEntity = $this->postTransformer->toObj($id, $personalPost, $dancePost);
        $entryEntityToArray = $entryEntity->toArray();
        $existingData[$id] = $entryEntityToArray;

        $this->entryFile->store($existingData);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $existingData = $this->entryFile->read();
        if (isset($existingData[$id])) {
            unset($existingData[$id]);
        }
        
        
        $this->base->getLogger()->log($existingData, '$existingData');
        
        $this->entryFile->store($existingData);
    }
}