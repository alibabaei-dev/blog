
<?php
require_once __DIR__ . '/../app/controllers/PostController.php';
require_once '../autoload.php';

$action = $_GET['action'] ?? 'index';
$controller = new PostController();

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "صفحه مورد نظر یافت نشد.";
}
