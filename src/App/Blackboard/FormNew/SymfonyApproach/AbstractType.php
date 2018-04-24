<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach;


abstract class AbstractType
{
    /**
     * @param BuilderInterface $builder
     */
    public function build(BuilderInterface $builder)
    {
        
    }

    /**
     * @param ResolverInterface $resolver
     */
    public function resolve(ResolverInterface $resolver)
    {
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}