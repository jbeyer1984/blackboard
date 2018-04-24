<?php


namespace src\Core\Form;


interface ResolverInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function setDefault($options);
}