<?php


namespace src\Core\Form\Components\Type\Output;


class SimpleType
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $on;

    /**
     * SimpleType constructor.
     * @param string $namespace
     * @param string $value
     * @param bool $on
     */
    public function __construct($namespace, $value, $on = false)
    {
        $this->namespace = $namespace;
        $this->value     = $value;
        $this->on        = $on;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isOn()
    {
        return $this->on;
    }
}