
<?php

define('ROOT_PATH', __DIR__ . '/../');

require_once ROOT_PATH . 'app/autoload.php';

$action = $_GET['action'] ?? 'index';
$controller = new PostController();

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "صفحه مورد نظر یافت نشد.";
}
