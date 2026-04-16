<?php
// Strict Router for Admin Modules
session_start();
require_once __DIR__ . '/config/config.php';

// Security Guard: Check if user is logged in and has admin role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // If not admin, redirect to user login page
    header('Location: index.php?controller=auth&action=login&error=Access+Denied');
    exit;
}

// Register Admin Controllers
require_once __DIR__ . '/controllers/AdminCategoryController.php';
require_once __DIR__ . '/controllers/AdminComicController.php';
require_once __DIR__ . '/controllers/AdminOrderController.php';
require_once __DIR__ . '/controllers/AdminPaymentController.php';
require_once __DIR__ . '/controllers/AdminReportController.php';
require_once __DIR__ . '/controllers/AdminUserController.php';

$controllerType = isset($_GET['controller']) ? $_GET['controller'] : 'report'; // Dashboard/Report as default

$controller = null;

switch ($controllerType) {
    case 'comic':
        $controller = new AdminComicController();
        break;
    case 'order':
        $controller = new AdminOrderController();
        break;
    case 'payment':
        $controller = new AdminPaymentController();
        break;
    case 'report':
        $controller = new AdminReportController();
        break;
    case 'category':
        $controller = new AdminCategoryController();
        break;
    case 'user':
        $controller = new AdminUserController();
        break;
    default:
        $controller = new AdminReportController();
        break;
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

if ($controller && method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>
