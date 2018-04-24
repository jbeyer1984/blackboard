<?php


namespace src\Core\Form;


class NestedBuilderRelation
{
    private $identifier;
    
    private $parentIdentifier;
    
    private $childrenIdentifiers = [];

    /**
     * NestedBuilderRelation constructor.
     * @param $identifier
     * @param $parentIdentifier
     */
    public function __construct($identifier, $parentIdentifier)
    {
        $this->identifier         = $identifier;
        $this->parentIdentifier   = $parentIdentifier;
    }

    public function addChildren($identifier)
    {
        $this->childrenIdentifiers[] = $identifier;
    }

    public function printIt()
    {
        $dump = print_r($this->identifier, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $this->identifier ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        $dump = print_r($this->parentIdentifier, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $this->parentIdentifier ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
        $dump = print_r($this->childrenIdentifiers, true);
        error_log(PHP_EOL . '-$- in ' . basename(__FILE__) . ':' . __LINE__ . ' in ' . __METHOD__ . PHP_EOL . '*** $this->childrenIdentifiers ***' . PHP_EOL . " = " . $dump . PHP_EOL, 3, '/home/jbeyer/error.log');
        
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    public function getParentIdentifier()
    {
        return $this->parentIdentifier;
    }

    /**
     * @return array
     */
    public function getChildrenIdentifiers()
    {
        return $this->childrenIdentifiers;
    }
}