<?php


namespace src\Core\Entity;


use src\Core\Form\Components\Request\RequestDataBind;

interface TransformerInterface
{
    /**
     * @param $requestVal
     * @param RequestDataBind $bind
     * @return mixed
     */
    public function toObj($requestVal, RequestDataBind $bind = null);
}