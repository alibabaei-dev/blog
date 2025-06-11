<?php

class Controller {
    public function model($modelName) {
        $dbConnection = Database::getInstance()->getConnection(); 
        return new $modelName($dbConnection);
    }
    public function view($viewPath, $data = []) {
        extract($data);
        require_once ROOT_PATH . "app/views/{$viewPath}.php"; 
    }
}