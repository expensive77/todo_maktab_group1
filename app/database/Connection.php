<?php

namespace App\database;

use PDO;

class Connection
{
    private PDO $connection;

    private array $config;

    private static $instance = null;

    private function __construct()
    {
        $this->config = include(__DIR__ . '/../config/database.php');
        $this->connection = $this->connect();
    }

    private function __clone(){}

    private function connect() {
        $driver = $this->config['driver'];
        $dbname = $this->config['dbname'];
        $host = $this->config['host'];
        $username = $this->config['username'];
        $password = $this->config['password'];


        $dsn = "$driver:host=$host;dbname=$dbname";

        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $pdo;
    }

    public function getConnection(){
        return $this->connection;
    }


    public static function getInstance(){

        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }
}