<?php
// Simple Router for User Frontend

require_once __DIR__ . '/controllers/HomeController.php';

$controller = new HomeController();

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'index':
    default:
        $controller->index();
        break;
}
?>
