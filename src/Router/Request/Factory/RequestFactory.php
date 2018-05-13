<?php

namespace src\Router\Request\Factory;

use src\Router\Request\Get;
use src\Router\Request\Post;
use src\Router\Request\Request;

class RequestFactory
{
    /**
     * @var Request
     */
    private static $request;

    /**
     * @return Request
     */
    public static function getCreatedRequest()
    {
        if (is_null(self::$request)) {
            $self = new self();
            self::$request = $self->createRequest();
        }
        
        return self::$request;
    }

    /**
     * @return Request
     */
    private function createRequest()
    {
        $request = new Request($this->createGet(), $this->createPost());
        
        return $request;
    }

    /**
     * @return Get
     */
    protected function createGet()
    {
        $get = new Get($_GET);
        
        return $get;
    }

    /**
     * @return Post
     */
    protected function createPost()
    {
        $post = new Post($_POST);
        
        return $post;
    }
    
    
    
    
    
    
}