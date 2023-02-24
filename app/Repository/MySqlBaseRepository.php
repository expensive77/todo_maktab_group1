<?php

namespace App\Repository;

use App\database\Connection;
use App\database\QueryBuilder;

class MySqlBaseRepository {
    
    protected $connection;
    protected $builder;

    public function __construct()
    {
        // $this->builder = new QueryBuilder;
        // $this->connection = Connection::getInstance()
        // ->getConnection();
    }
}