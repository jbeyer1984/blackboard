<?php


namespace test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Transformer\Post;

use src\Core\Entity\TransformerInterface;
use src\Core\Form\Components\Request\RequestDataBind;
use test\App\Blackboard\FormNew\SymfonyApproach\Creator\Mock\Entity\DanceEntityCollection;

class DanceEntityCollectionTransformer implements TransformerInterface
{
    /**
     * @param mixed $requestVal
     * @param RequestDataBind $bind
     * @return DanceEntityCollection
     */
    public function toObj($requestVal, RequestDataBind $bind = null)
    {
        $dump = print_r("hallo", true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** "hallo" ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        if (is_array($requestVal)) {
            $dump = print_r($requestVal, true);
            error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $requestVal ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
            
        }
    }
}