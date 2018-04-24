<?php


namespace src\Core\Form\Components\Render\Components;


use src\Core\Form\Components\Render\RenderWrapperComponentInterface;

class Span implements RenderWrapperComponentInterface
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var []
     */
    private $options;

    /**
     * Area constructor.
     * @param $identifier
     * @param $options
     */
    public function __construct($identifier, $options = [])
    {
        $this->identifier = $identifier;
        $this->options    = $options;
    }

    /**
     * @return string
     */
    public function renderStart()
    {
        $html = <<<TXT
<span>
TXT;

        return $html;
    }

    /**
     * @return string
     */
    public function renderEnd()
    {
        $html = <<<TXT
</span>
TXT;

        return $html;
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
    public function getOption()
    {
        return $this->options;
    }
}