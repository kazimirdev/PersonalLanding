<?php
    class BlogController {
        public function index() {

            $GLOBALS['locale'] = $_GET['locale'] ?? 'en';

            $postModel = new Posts();
            $posts = $postModel->getAllByLocale($GLOBALS['locale']);

            

            require __DIR__ . '/../Views/blog/index.php';
        }
    }
?>