<?php
class AdminBlogPostController {
    
    public function index() {
        $posts = (new Posts())->getAllByLocale($locale = "en");
        require __DIR__ . '/../Views/admin/blog-posts/index.php';
    }

    public function create() {
        $locales = I18N::getSupportedLocales();
        require __DIR__ . '/../Views/admin/blog-posts/create.php';
    }

    public function edit($id) {
        $postModel = new Posts();
        $post = $postModel->getById($id);
        require __DIR__ . '/../Views/admin/blog-posts/edit.php';
    }

    public function store() {
        $slug = $_POST['slug'];

        $translations = [
            'en' => [
                'title' => $_POST['title_en'],
                'content' => $_POST['content_en'],
            ],
            'pl' => [
                'title' => $_POST['title_pl'],
                'content' => $_POST['content_pl'],
            ],
        ];

        $postModel = new Posts();
        $postModel->createPost($slug, $translations);
        header('Location: /admin/blog-posts');
        exit;
    }

    
}
?>