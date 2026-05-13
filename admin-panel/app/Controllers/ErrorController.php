<?php
    class ErrorController {
        public function index($errorCode, $errorDescription) {
            http_response_code((int)$errorCode);
            $page_title_header = $errorCode . ' - ' . $errorDescription;
            require __DIR__ . '/../Views/error/index.php';
        }
    }
?>
