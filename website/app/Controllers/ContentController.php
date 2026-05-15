<?php
    class ContentController {
        public function index() {
            $locale = I18N::get_locale();
            $postModel = new Posts();
            $posts = $postModel->getAllByLocale($GLOBALS['locale']);
            $prepage = url(getParentPage()) ?: '/';
            $page_title_header = get_i18n('content');

            require __DIR__ . '/../Views/content/index.php';
        }
        public function show($slug) {
            $locale = I18N::get_locale();
            $postModel = new Posts();
            $post = $postModel->getBySlugAndLocale($slug, $locale);
            
            // If post doesn't exist, show 404 error page
            if (!$post) {
                $errorCode = 404;
                $errorDescription = 'Page Not Found';
                (new ErrorController())->index($errorCode, $errorDescription);
                return;
            }
            
            $prepage = url(getParentPage());
            $page_title_header = "[kazimir.dev]";
            require __DIR__ . '/../Views/content/show.php';
        }
    }
?>