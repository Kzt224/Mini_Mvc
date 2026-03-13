<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{

    private static $instance = null;
    private $conn;

    private function __construct($config)
    {
        try {

            $tmpDsn = "mysql:host={$config['host']}";
            $tmpConn = new PDO($tmpDsn, $config['user'], $config['pass']);
            $tmpConn->exec("CREATE DATABASE IF NOT EXISTS {$config['name']}");


            $dsn = "mysql:host={$config['host']};dbname={$config['name']}";
            $this->conn = new PDO($dsn, $config['user'], $config['pass']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            $configFile = BASE_PATH . "/config/config.php";
            $dbConfig = include($configFile);
            self::$instance = new Database($dbConfig['db']);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
