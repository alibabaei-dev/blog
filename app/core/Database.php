<?php

class Database {
private $pdodb;

 public function __construct (){
    try {
$config = require(__DIR__ . '/db-config.php');
$db_host = $config['host'];
$db_name = $config['name'];
$db_user = $config['user'];
$db_pass = $config['pass'];

        $this->pdodb = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
    public function getConnection() {
    return $this->pdodb;
}
}
?>
