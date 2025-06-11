<?php
class Database {
    private static $instance = null;
    private $connection;

    private $host = 'localhost';
    private $db_name = 'myblog';
    private $username = 'root';
    private $password = '';

    private function __construct() {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
