<?php

final class DB
{
    private static ?PDO $pdo = null;

    private static function pdoServer(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;charset=%s',
            env('DB_HOST', '127.0.0.1'),
            env('DB_CHARSET', 'utf8mb4')
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO(
            $dsn,
            env('DB_USER', 'root'),
            env('DB_PASS', ''),
            $options
        );
    }

    public static function pdo(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $dbName = env('DB_NAME');

        if (!$dbName) {
            throw new RuntimeException('DB_NAME is not set in .env');
        }

        $charset = env('DB_CHARSET', 'utf8mb4');

        // Ensure database exists
        $server = self::pdoServer();

        $server->exec(
            "CREATE DATABASE IF NOT EXISTS `{$dbName}`
             CHARACTER SET {$charset}
             COLLATE {$charset}_general_ci"
        );

        // Connect to database
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            env('DB_HOST', '127.0.0.1'),
            $dbName,
            $charset
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        self::$pdo = new PDO(
            $dsn,
            env('DB_USER', 'root'),
            env('DB_PASS', ''),
            $options
        );

        return self::$pdo;
    }
}
