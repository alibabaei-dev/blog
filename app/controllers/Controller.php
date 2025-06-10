<?php

class Controller {
    public function model($modelName) {
        require_once __DIR__ . "/../models/{$modelName}.php";
        return new $modelName();
    }

    public function view($viewPath, $data = []) {
        extract($data);
        require_once __DIR__ . "/../views/{$viewPath}.php";
    }
}
