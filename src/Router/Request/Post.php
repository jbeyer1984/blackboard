<?php


namespace src\Router\Request;


class Post extends GetPostBase
{
    public function getAllParams()
    {
        return $_POST;
    }
}