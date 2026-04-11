<?php
require_once __DIR__ . '/webConfig.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function daDangNhapNguoiDung(): bool
{
    return isset($_SESSION['user_login']) && is_array($_SESSION['user_login']);
}

function batBuocDangNhap(): void
{
    if (!daDangNhapNguoiDung()) {
        header('Location: ' . BASE_URL . '/public/sign/up/login.php');
        exit;
    }
}