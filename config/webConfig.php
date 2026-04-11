<?php
require_once __DIR__ . '/helper.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

if (!defined('PUBLIC_URL')) {
    define('PUBLIC_URL', BASE_URL . '/public');
}

if (!defined('ASSET_URL')) {
    define('ASSET_URL', BASE_URL . '/assets');
}

$tenWebsite = 'Mực Chuyển Động';