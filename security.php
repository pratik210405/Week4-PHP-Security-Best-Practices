<?php
/*
 * Week 4 Security Helpers
 * Include this file near the top of pages that process forms.
 * Use e($value) when displaying untrusted values in HTML.
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
    // Set cookie protections before session_start().
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax'
    ]);
    session_start();
}

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(): bool {
    $sent = $_POST['csrf_token'] ?? '';
    return is_string($sent)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $sent);
}

/*
 * Example form field:
 * <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
 *
 * Before processing a POST request:
 * if (!verify_csrf_token()) {
 *     http_response_code(403);
 *     exit('Invalid request token. Please reload the form and try again.');
 * }
 *
 * Keep using prepared statements for every INSERT, UPDATE, SELECT, and DELETE
 * query that contains user-supplied values.
 */
