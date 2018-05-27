<?php

namespace src\Utilities;

class Template
{
//    private $data;
    
    public function getView($viewFile, $arr = [])
    {
//        $this->data = $arr;
        if (!empty($arr)) {
            extract($arr);
        }
        include_once(VIEW_PATH . '/' . $viewFile);
    }
}
