<?php

namespace src\Utilities;

use PDO;

class Db
{
    private $connection;
    
    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->connection = new PDO('mysql:dbname=check;host=db:3306', 'root', 'user20');
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }
}