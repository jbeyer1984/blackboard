<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post;


use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Provider\ProviderDataIterator;
use src\Core\Form\Components\Request\RequestDataBind;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntity;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\ExperienceEntityCollection;
use test\App\Blackboard\FormNew\SymfonyApproach\Factory\BlackboardBaseDataFactory;

class ExperienceEntityCollectionTransformer implements TransformerInterface
{
    /**
     * @param mixed $requestVal
     * @param RequestDataBind $bind
     * @return ExperienceEntityCollection
     */
    public function toObj($requestVal, RequestDataBind $bind = null)
    {
        $experienceCollection = new ExperienceEntityCollection();
        
        $data = $bind->getData();
        if ($data instanceof ProviderDataIterator) {
            $dataToChange = $data->getData();
            if ($dataToChange instanceof ExperienceEntityCollection) {
                $blackboardBaseData = BlackboardBaseDataFactory::getBlackboardBaseDataFromJson();
                /** @var ExperienceEntityCollection $experienceEntityCollection */
                $experienceEntityCollection = $blackboardBaseData
                    ->getExperienceEntityCollection()
                ;

                $experienceCollectionMap = [];
                foreach ($experienceEntityCollection->getCollection() as $experienceEntity) {
                    $experienceCollectionMap[$experienceEntity->getId()] = $experienceEntity;
                }

                $id = $requestVal;
                /** @var ExperienceEntity $experienceEntity */
                $experienceEntity = $experienceCollectionMap[$id];
                $name = $experienceEntity->getName();
                $experienceCollection->add(new ExperienceEntity($id, $name));
            }
        }
        
        return $experienceCollection;
    }
}