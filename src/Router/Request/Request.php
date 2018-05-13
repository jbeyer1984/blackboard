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

    /**
     * Request constructor.
     * @param Get $get
     * @param Post $post
     */
    public function __construct(Get $get, Post $post)
    {
        $this->get  = $get;
        $this->post = $post;
    }


//    public function __construct()
//    {
//        $this->init();
//    }

//    protected function init()
//    {
//        $this->get = new Get($_GET);
//        $this->post = new Post($_POST);
//    }

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