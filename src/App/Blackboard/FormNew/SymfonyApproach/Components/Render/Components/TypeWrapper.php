<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Render\Components;


class TypeWrapper
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $htmlTag;

    /**
     * BuilderCollectionWrapper constructor.
     * @param string $identifier
     * @param string $htmlTag
     */
    public function __construct($identifier, $htmlTag)
    {
        $this->identifier = $identifier;
        $this->htmlTag    = $htmlTag;
    }

    public function renderStart()
    {
        $html = $this->htmlTag;
        
        return $html;
    }

    public function renderEnd()
    {
        $explodedHtmlTag = explode('<', $this->htmlTag);
        $implodedHtmlTag = implode('</', $explodedHtmlTag);
        
        return $implodedHtmlTag;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}