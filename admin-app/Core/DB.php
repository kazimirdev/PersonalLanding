<?php

class DB {

    private static ?PDO $pdo = null; // PHP Data Object, PDO or null, singleton pattern

    public static function connect(): PDO {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/db.php'; // Load database configuration

            $attempts = 0;

            while ($attempts < 10) {
                try {
                    self::$pdo = new PDO(
                        $config['dsn'], 
                        $config['user'], 
                        $config['pass'],
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as associative arrays
                            PDO::ATTR_EMULATE_PREPARES => false, // Use native prepared statements if supported
                        ]);
                    break; // Connection successful, exit loop
                } catch (PDOException $e) {
                    error_log("Database connection failed: " . $e->getMessage());
                    $attempts++;
                    sleep(1*$attempts); // Wait before retrying

                    if ($attempts === 10) {
                        throw new Exception("Unable to connect to the database after multiple attempts.\n Error: " . $e->getMessage());
                    }
                }
            }

        }
        return self::$pdo;
    }
}

?>