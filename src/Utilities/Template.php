<?php

namespace src\Utilities;

class Template
{
//    private $data;
    
    public function getView($viewFile, $arr)
    {
//        $this->data = $arr;
        extract($arr);
        include_once(VIEW_PATH . '/' . $viewFile);
    }
}
