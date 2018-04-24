<?php


namespace src\App\Blackboard\Form\Transformer\Post;


use src\App\Blackboard\_Blackboard;
use src\App\Blackboard\Entity\ExperienceEntity;
use src\App\Blackboard\Entity\ExperienceEntityCollection;
use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Components\Request\RequestDataBind;
use src\Core\DI\Service;
use src\App\Blackboard\BlackboardBaseDataFromJson;

class ExperienceEntityCollectionTransformer
{
    /**
     * @param mixed $requestVal
     * @param RequestDataBind $bind
     * @return ExperienceEntityCollection
     */
    public function toObj($requestVal, RequestDataBind $bind)
    {
        $experienceEntityCollection = new ExperienceEntityCollection();
        
        $data = $bind->getData();
        if ($data instanceof ProviderDataIterator) {
            $dataToChange = $data->getData();
            if ($dataToChange instanceof ExperienceEntityCollection) {

                /** @var ExperienceEntityCollection $allExperienceEntityCollection */
                $allExperienceEntityCollection = Service::get(_Blackboard::class)
                    ->getSingle(BlackboardBaseDataFromJson::class)
                    ->getExperienceEntityCollection()
                ;

                $experienceCollectionMap = [];
                foreach ($allExperienceEntityCollection->getCollection() as $experienceEntity) {
                    $experienceCollectionMap[$experienceEntity->getId()] = $experienceEntity;
                }

                $id = $requestVal;
                /** @var ExperienceEntity $experienceEntity */
                $experienceEntity = $experienceCollectionMap[$id];
                
                $name = $experienceEntity->getName();
                $experienceEntityCollection->add(new ExperienceEntity($id, $name));
            }
        }
        
        return $experienceEntityCollection;
    }
}