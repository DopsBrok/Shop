<?php
// Утилита для ENV
function env(string $key, $default = '') {
    return $_ENV[$key] ?? getenv($key) ?: $default;
}

// Подхват из Render → render.yaml
define('DB_HOST', env('DB_HOST', '127.0.0.1'));
define('DB_NAME', env('DB_NAME', 'shop'));
define('DB_USER', env('DB_USER', 'shop_user'));
define('DB_PASS', env('DB_PASS', 'strong_password'));

// HTTP-заголовки безопасности остаются неизменными
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
header("X-XSS-Protection: 1; mode=block");
?>