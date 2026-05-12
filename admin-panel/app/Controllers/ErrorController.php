<?php
    class ErrorController {
        public function index($errorCode, $errorDescription) {
            $page_title_header = $errorCode . ' - ' . $errorDescription;
            require __DIR__ . '/../Views/error/index.php';
        }
    }
?>
