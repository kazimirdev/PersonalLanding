<?php
class AdminContentController {
    
    public function index() {
        $posts = (new Posts())->getAllByLocale($locale = "en");
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
        $locales = I18N::getSupportedLocales();
        require __DIR__ . '/../Views/admin/content/create.php';
    }

    public function edit($id) {
        $postModel = new Posts();
        $post = $postModel->getById($id);
        require __DIR__ . '/../Views/admin/content/edit.php';
    }

    public function delete($id) {
        $postModel = new Posts();
        $postModel->deleteById($id);
        header('Location: /admin/content');
        exit;
    }

    public function store() {
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
        echo "Received data: " . print_r(['slug' => $slug, 'image_preview_url' => $image_preview_url, 'translations' => $translations], true);
        $postModel = new Posts();
        $postModel->createContentPost($slug, $translations, $image_preview_url);
        header('Location: /admin/content');
        exit;
    }

    
}
?>