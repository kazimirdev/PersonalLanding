<?php
class AdminContentTagsController {
    
    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /');
            exit();
        }
    }
    
    public function index() {
        $this->requireAuth();
        $tags = (new ContentTags())->getAllTags();
        require __DIR__ . '/../Views/admin/content-tags/index.php';
    }

    public function create() {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/content-tags/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/content-tags/edit.php';
    }

    public function store() {
        $this->requireAuth();
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
        header('Location: /content-tags');
        exit;
    }

    public function delete($id) {
        $this->requireAuth();
        $contentTagModel = new ContentTags();
        $contentTagModel->deleteById($id);
        header('Location: /content-tags');
        exit;
    }
    
}
?>