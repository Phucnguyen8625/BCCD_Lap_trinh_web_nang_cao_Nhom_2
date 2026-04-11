<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function themeHopLe(string $theme): bool
{
    return in_array($theme, ['light', 'dark', 'comic'], true);
}

function chuanHoaTheme(?string $theme): string
{
    $theme = is_string($theme) ? trim($theme) : '';

    return themeHopLe($theme) ? $theme : 'light';
}

function layThemeHienTai(): string
{
    $theme = $_SESSION['app_theme'] ?? ($_COOKIE['app_theme'] ?? 'light');
    $theme = chuanHoaTheme($theme);

    $_SESSION['app_theme'] = $theme;

    return $theme;
}

function luuTheme(string $theme): void
{
    $theme = chuanHoaTheme($theme);

    $_SESSION['app_theme'] = $theme;

    if (!headers_sent()) {
        setcookie('app_theme', $theme, [
            'expires' => time() + (60 * 60 * 24 * 30),
            'path' => '/',
            'samesite' => 'Lax',
        ]);
    }
}
