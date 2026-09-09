<?php
declare(strict_types=1);

/**
 * Redirects anonymous visitors to the login page. Must be called
 * after session_start(), on every page that requires a logged-in user.
 */
function require_login(): void
{
    if (empty($_SESSION['usernameverification'])) {
        header('Location: login.php');
        exit;
    }
}
