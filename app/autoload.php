<?php

spl_autoload_register(function($className) {
    $paths = [
        ROOT_PATH . 'app/controllers/', 
        ROOT_PATH . 'app/models/',
        ROOT_PATH . 'app/core/',
        ROOT_PATH . 'app/entities/',
        ROOT_PATH . 'app/requests/',
        ROOT_PATH . 'app/services/',
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});