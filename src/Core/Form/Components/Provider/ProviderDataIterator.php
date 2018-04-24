<?php


namespace src\Core\Form\Components\Provider;


class ProviderDataIterator
{
    private $data;
    
    private $provider;

    /**
     * @var string
     */
    private $iteratorClass;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var array
     */
    private $postRelevant;
    
    /**
     * @var array
     */
    private $addAttributes;

    /**
     * ProviderDataIterator constructor.
     * @param $data
     * @param $provider
     * @param string $iteratorClass
     * @param string $identifier
     * @param array $postRelevant
     * @param array $addAttributes
     */
    public function __construct($data, $provider, $iteratorClass, $identifier, array $postRelevant = [], array $addAttributes = [])
    {
        $this->data          = $data;
        $this->provider      = $provider;
        $this->iteratorClass = $iteratorClass;
        $this->identifier    = $identifier;
        $this->postRelevant  = $postRelevant;
        $this->addAttributes = $addAttributes;
    }


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getIteratorClass()
    {
        return $this->iteratorClass;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return array
     */
    public function getPostRelevant()
    {
        return $this->postRelevant;
    }

    /**
     * @return array
     */
    public function getAddAttributes()
    {
        return $this->addAttributes;
    }
}