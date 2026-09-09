<?php
declare(strict_types=1);

/**
 * Reads a value from .env (project root), falling back to $default.
 * .env is git-ignored so real credentials never reach the repository.
 */
function env(string $key, ?string $default = null): ?string
{
    static $loaded = false;

    if (!$loaded) {
        $envFile = __DIR__ . '/../.env';
        if (is_file($envFile)) {
            foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                    continue;
                }
                [$name, $value] = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value, " \t\n\r\0\x0B\"'");
                if (getenv($name) === false) {
                    putenv("{$name}={$value}");
                }
            }
        }
        $loaded = true;
    }

    $value = getenv($key);
    return $value === false ? $default : $value;
}

/**
 * Returns a shared PDO connection built from .env settings.
 */
function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host = env('DB_HOST', 'localhost');
        $name = env('DB_NAME', 'test');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $charset = env('DB_CHARSET', 'utf8mb4');

        try {
            $pdo = new PDO(
                "mysql:host={$host};dbname={$name};charset={$charset}",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            // Never leak connection details (host, db name, credentials) to visitors.
            error_log('Database connection failed: ' . $e->getMessage());
            http_response_code(500);
            die('Une erreur est survenue. Veuillez réessayer plus tard.');
        }
    }

    return $pdo;
}
