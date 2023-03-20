<?php

namespace App\Model;

use App\Helpers\Orm;

class DB {
    private $host = "volk-db";
    private $username = "root";
    private $password = "testeVolks";
    private $database = "volk";

    public $connection;

    // Create connection
    public function __construct() {
        try {



//            $this->connection = new \PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
//            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//            $this->connection->exec("set names utf8mb4");


            $pdo = new \PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8mb4");
            return $this->connection = new Orm($pdo);

        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
