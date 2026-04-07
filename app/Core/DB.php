<?php

class DB {

    private static ?PDO $pdo = null; // PHP Data Object, PDO or null, singleton pattern

    public static function connect(): PDO {
        if (self::$pdo === null) {
            require __DIR__ . '../../config/db.php'; // Load database configuration

            self::$pdo = new PDO(
                $config['dsn'], 
                $config['user'], 
                $config['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
                    PDO::ATTR_EMULATE_PREPARES => false, // Use native prepared statements if supported
                ]);
        }
        return self::$pdo;
    }
}

?>