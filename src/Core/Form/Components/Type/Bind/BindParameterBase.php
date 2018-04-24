<?php


namespace src\Core\Form\Components\Type\Bind;


class BindParameterBase
{
    /**
     * @var array
     */
    private $bindMap;

    /**
     * BindParameter constructor.
     * @param array $bindMap
     */
    public function __construct(array $bindMap)
    {
        $this->bindMap = $bindMap;
    }

    /**
     * @return array
     */
    public function getBindMap()
    {
        return $this->bindMap;
    }
}