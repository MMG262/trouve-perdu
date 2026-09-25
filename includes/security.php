<?php
declare(strict_types=1);

/**
 * Starts the session with hardened cookie settings. Must be called
 * instead of session_start() at the top of every page.
 */
function start_secure_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $https,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    ini_set('session.use_strict_mode', '1');
    session_start();
}

/**
 * Returns the CSRF token of the current session, creating it if needed.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Hidden input to put inside every POST form.
 */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}

/**
 * Stops the request if a POST does not carry the session's CSRF token.
 */
function verify_csrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        die('Requête invalide. Veuillez recharger la page et réessayer.');
    }
}

/**
 * True when every listed POST field is a non-empty string (server-side
 * counterpart of the HTML "required" attribute, which can be bypassed).
 */
function post_fields_filled(array $names): bool
{
    foreach ($names as $name) {
        if (!isset($_POST[$name]) || !is_string($_POST[$name]) || trim($_POST[$name]) === '') {
            return false;
        }
    }
    return true;
}
