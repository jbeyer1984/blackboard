<?php


namespace src\App\Blackboard\Form\Transformer\Post;


use src\App\Blackboard\Entity\ExperienceEntity;
use src\App\Blackboard\Entity\ExperienceEntityCollection;
use src\App\Blackboard\Factory\BlackboardBaseDataFactory;
use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Components\Request\RequestDataBind;

class ExperienceEntityCollectionTransformer implements TransformerInterface
{
    /**
     * @param mixed $requestVal
     * @param RequestDataBind $bind
     * @return ExperienceEntityCollection
     */
    public function toObj($requestVal, RequestDataBind $bind = null)
    {
        $factory = new BlackboardBaseDataFactory();
        $experienceEntityCollection = new ExperienceEntityCollection();
        
        $data = $bind->getData();
        if ($data instanceof ProviderDataIterator) {
            $dataToChange = $data->getData();
            if ($dataToChange instanceof ExperienceEntityCollection) {
                $blackboardBaseData = $factory->getBlackboardBaseDataFromJson();
                /** @var ExperienceEntityCollection $allExperienceEntityCollection */
                $allExperienceEntityCollection = $blackboardBaseData
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