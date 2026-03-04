<?php

final class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $dbName = env('DB_NAME');

        if (!$dbName) {
            throw new DatabaseConnectionException(
                500,
                'Server Error',
                'Database configuration missing.',
                'DB_NAME is not set in .env'
            );
        }

        $host = env('DB_HOST', '127.0.0.1');
        $user = env('DB_USER', 'root');
        $pass = env('DB_PASS', '');
        $charset = env('DB_CHARSET', 'utf8mb4');

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $host,
            $dbName,
            $charset
        );

        try {

            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {

            $errorInfo  = $e->errorInfo ?? [];
            $driverCode = $errorInfo[1] ?? null;

            if ($driverCode === 1049) {
                throw new DatabaseConnectionException(
                    500,
                    'Server Error',
                    'Database does not exist.',
                    "Database '{$dbName}' does not exist."
                );
            }

            if ($driverCode === 1045) {
                throw new DatabaseConnectionException(
                    500,
                    'Server Error',
                    'Database access denied.',
                    'Check DB_USER / DB_PASS in .env'
                );
            }

            if ($driverCode === 2002) {
                throw new DatabaseConnectionException(
                    500,
                    'Server Error',
                    'Cannot connect to database server.',
                    "MySQL host '{$host}' unreachable."
                );
            }

            throw new DatabaseConnectionException(
                500,
                'Server Error',
                'Database connection failed.',
                $e->getMessage()
            );
        }

        return self::$pdo;
    }
}
