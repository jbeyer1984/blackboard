<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach;


use src\App\Blackboard\FormNew\SymfonyApproach\Components\Type\Bind\BindParameterBase;

interface BuilderInterface
{
    /**
     * @param string $identifier
     * @param string $type
     * @param array $options
     * @return mixed
     */
    public function add($identifier, $type, $options = []);

    /**
     * @param BindParameterBase $bind
     * @return mixed
     */
    public function bind(BindParameterBase $bind);
}