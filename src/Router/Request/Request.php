<?php


namespace src\Router\Request;


class Request
{
    /**
     * @var Get
     */
    private $get;

    /**
     * @var Post
     */
    private $post;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->get = new Get();
        $this->post = new Post();
    }

    /**
     * @return Get
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }
}