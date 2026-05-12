<?php
class AdminProductController {
    public function index() {
        require __DIR__ . '/../../Views/admin/products/index.php';
    }

    public function create() {
        require __DIR__ . '/../../Views/admin/products/create.php';
    }

    public function edit($id) {
        require __DIR__ . '/../../Views/admin/products/edit.php';
    }
}
?>