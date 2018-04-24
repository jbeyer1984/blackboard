<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach;


interface ResolverInterface
{
    /**
     * @param array $options
     * @return mixed
     */
    public function setDefault($options);
}