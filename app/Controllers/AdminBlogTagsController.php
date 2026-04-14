<?php
class AdminTagsPostController {
    
    public function index() {
        require __DIR__ . '/../../Views/admin/posts/index.php';
    }

    public function create() {
        require __DIR__ . '/../../Views/admin/posts/create.php';
    }

    public function edit($id) {
        require __DIR__ . '/../../Views/admin/posts/edit.php';
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
        header('Location: /admin/posts');
        exit;
    }

    
}
?>