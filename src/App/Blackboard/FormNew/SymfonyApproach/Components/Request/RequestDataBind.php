<?php


namespace src\App\Blackboard\FormNew\SymfonyApproach\Components\Request;


use src\App\Blackboard\FormNew\SymfonyApproach\Builder;

class RequestDataBind
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @var string[]
     */
    private $attributes;

    /**
     * @var mixed
     */
    private $htmlType;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var mixed
     */
    private $transformer;

    /**
     * RequestDataBind constructor.
     * @param mixed $data
     * @param string[] $attributes
     * @param mixed $htmlType
     * @param $builder
     * @param null $transformer
     */
    public function __construct($data, array $attributes, $htmlType, Builder $builder, $transformer = null)
    {
        $this->data        = $data;
        $this->attributes  = $attributes;
        $this->htmlType    = $htmlType;
        $this->builder = $builder;
        $this->transformer = $transformer;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function forceData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getHtmlType()
    {
        return $this->htmlType;
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}