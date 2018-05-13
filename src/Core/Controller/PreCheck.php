<?php


namespace src\Core\Controller;


interface PreCheck
{
    /**
     * @return bool
     */
    public function preCheck();
}