<?php
// Simple Router for Admin Categories

require_once __DIR__ . '/controllers/AdminCategoryController.php';
require_once __DIR__ . '/controllers/AdminComicController.php';

$controllerType = isset($_GET['controller']) ? $_GET['controller'] : 'category';

if ($controllerType == 'comic') {
    $controller = new AdminComicController();
} else {
    $controller = new AdminCategoryController();
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
?>
