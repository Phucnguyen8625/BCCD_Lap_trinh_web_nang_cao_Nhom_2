<?php
require_once __DIR__ . '/helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vì project của bạn đang chạy kiểu:
// http://localhost:8080/admin/login.php
// nên BASE_URL có thể để rỗng
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

if (!defined('ADMIN_URL')) {
    define('ADMIN_URL', BASE_URL . '/admin');
}

function isAdminLoggedIn(): bool
{
    return !empty($_SESSION['admin_logged_in']);
}

function adminLogin(array $user = []): void
{
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $user['username'] ?? 'admin';
    $_SESSION['admin_name'] = $user['name'] ?? 'Quản trị viên';
}

function adminLogout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function requireAdminLogin(): void
{
    if (!isAdminLoggedIn()) {
        header('Location: ' . ADMIN_URL . '/login.php');
        exit;
    }
}

function adminCurrentUserName(): string
{
    return $_SESSION['admin_name'] ?? 'Quản trị viên';
}