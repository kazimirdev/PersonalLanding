<?php
    class CVController {
        public function index() {
            header('Content-Type: application/pdf');
            readfile(__DIR__ . '/../Views/cv/cv.pdf');
            exit;
        }
    }
?>