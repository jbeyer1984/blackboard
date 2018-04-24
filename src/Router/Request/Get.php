<?php


namespace src\Router\Request;


class Get extends GetPostAbstract
{
    public function getAllParams()
    {
        return $_GET;
    }
}