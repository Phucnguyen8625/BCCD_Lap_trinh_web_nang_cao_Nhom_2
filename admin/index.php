<?php
require_once __DIR__ . '/../config/AdminConfig.php';

if (isAdminLoggedIn()) {
    header('Location: ' . ADMIN_URL . '/dashboard/index.php');
    exit;
}

header('Location: ' . ADMIN_URL . '/Login.php');
exit;
