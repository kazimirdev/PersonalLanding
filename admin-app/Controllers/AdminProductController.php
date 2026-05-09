<?php
class AdminProductController {
    
    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /');
            exit();
        }
    }
    
    public function index() {
        $this->requireAuth();
        $locale = $GLOBALS['locale'] ?? 'en';
        $products = (new Product())->getAllProductsByLocale($locale);
        require __DIR__ . '/../Views/admin/products/index.php';
    }

    public function create() {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/products/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        $product = (new Product())->getProductById($id);
        require __DIR__ . '/../Views/admin/products/edit.php';
    }

    public function store() {
        $this->requireAuth();
        $slug = $_POST['slug'] ?? null;
        $translations = [
            'en' => [
                'name' => $_POST['name_en'] ?? null,
                'description_md' => $_POST['description_en'] ?? null,
                'description_html' => nl2br(htmlspecialchars($_POST['description_en'] ?? '')),
            ],
            'pl' => [
                'name' => $_POST['name_pl'] ?? null,
                'description_md' => $_POST['description_pl'] ?? null,
                'description_html' => nl2br(htmlspecialchars($_POST['description_pl'] ?? '')),
            ],
        ];
        $productModel = new Product();
        $productModel->createProduct($slug, $translations);
        header('Location: /products');
        exit;
    }

    public function delete($id) {
        $this->requireAuth();
        $productModel = new Product();
        $productModel->deleteById($id);
        header('Location: /products');
        exit;
    }
}
?>