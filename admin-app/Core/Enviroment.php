<?php

class Enviroment {
    private static $env = [];

    public static function load($filePath = __DIR__ . '/../../.env') {
        if ((!file_exists($filePath) || !is_readable($filePath)) && !file_exists(".env.jenkins")) {
            throw new Exception("Env file not found or not readable: " . $filePath);
        } elseif (file_exists(".env.jenkins")) {
            // If .env.jenkins exists, get env from Jenkins instead of the .env file.
            // This file could be empty, 
            // but it should exist to indicate that env variables are set in Jenkins
            // This is useful for CI/CD pipelines, 
            // where we don't want to store sensitive env variables in a file on the server, 
            // but rather set them in Jenkins and access them via getenv().
        } else { 
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#')) {
                    continue; // Skip comments
                }
                $parts = explode('=', $line, 2);
                if (count($parts) !== 2) {
                    continue; // Skip malformed lines
                }
                [$key, $value] = $parts;
                self::$env[trim($key)] = trim($value);
            }
        }
    }

    public static function get($key, $default = null) {
        return self::$env[$key] ?? $default;
    }
}

?>