<?php
class AdminContentController {
    
    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /');
            exit();
        }
    }
    
    public function index() {
        $this->requireAuth();
        $locale = $GLOBALS['locale'] ?? 'en';
        $posts = (new Posts())->getAllByLocale($locale);
        require __DIR__ . '/../Views/admin/content/index.php';
    }

    public function show($slug) {
        $locale = I18N::get_locale();
        $postModel = new Posts();
        $post = $postModel->getBySlugAndLocale($slug, $locale);
        $page_title_header = $post['title'] ?? 'Post not found';
        require __DIR__ . '/../Views/admin/content/show.php';
    }

    public function create() {
        $this->requireAuth();
        $locales = I18N::getSupportedLocales();
        require __DIR__ . '/../Views/admin/content/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        $postModel = new Posts();
        $post = $postModel->getById($id);
        require __DIR__ . '/../Views/admin/content/edit.php';
    }

    public function delete($id) {
        $this->requireAuth();
        $postModel = new Posts();
        $postModel->deleteById($id);
        header('Location: /content');
        exit;
    }

    public function store() {
        $this->requireAuth();
        $slug = $_POST['slug'] ?? null;
        $image_preview_url = $_POST['image_preview_url'] ?? null;

        $translations = [
            'en' => [
                'title' => $_POST['title_en'] ?? null,
                'content_md' => $_POST['content_en'] ?? null,
                'content_html' => nl2br(htmlspecialchars($_POST['content_en'] ?? '')),
            ],
            'pl' => [
                'title' => $_POST['title_pl'] ?? null,
                'content_md' => $_POST['content_pl'] ?? null,
                'content_html' => nl2br(htmlspecialchars($_POST['content_pl'] ?? '')),
            ],
        ];
        $postModel = new Posts();
        $postModel->createContentPost($slug, $translations, $image_preview_url);
        header('Location: /content');
        exit;
    }

    
}
?>