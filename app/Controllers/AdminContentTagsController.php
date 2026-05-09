<?php
class AdminContentTagsController {
    
    public function index() {
        require __DIR__ . '/../../Views/admin/content-tags/index.php';
    }

    public function create() {
        require __DIR__ . '/../../Views/admin/content-tags/create.php';
    }

    public function edit($id) {
        require __DIR__ . '/../../Views/admin/content-tags/edit.php';
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

        $contentTagModel = new ContentTags();
        $contentTagModel->createContentTag($slug, $translations);
        header('Location: /admin/content-tags');
        exit;
    }

    
}
?>