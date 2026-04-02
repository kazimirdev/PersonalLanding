<?php
    class ErrorController {
        public function index($errorCode, $errorDescription) {
            require __DIR__ . '/../Views/error/index.php';
        }
    }
?>
