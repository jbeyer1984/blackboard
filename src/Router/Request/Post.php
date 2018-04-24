<?php


namespace src\Router\Request;


class Post extends GetPostAbstract
{
    public function getAllParams()
    {
        return $_POST;
    }
}