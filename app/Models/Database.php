<?php
class Database
{
    private static ?PDO $conn = null;

    public static function getConnection(): PDO
    {
        if (self::$conn === null) {
            $config = require __DIR__ . '/../../config/database.php';

            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                $config['driver'], $config['host'], $config['port'],
                $config['database'], $config['charset']
            );

            self::$conn = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        }
        return self::$conn;
    }
}
