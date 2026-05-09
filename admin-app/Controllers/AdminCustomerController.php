<?php
class AdminCustomerController {
    
    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /');
            exit();
        }
    }
    
    public function index() {
        $this->requireAuth();
        $customers = []; // Placeholder - no customers table yet
        require __DIR__ . '/../Views/admin/customers/index.php';
    }

    public function create() {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/customers/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/customers/edit.php';
    }

    public function store() {
        $this->requireAuth();
        // Implementation for creating/updating customers
        header('Location: /customers');
        exit;
    }

    public function delete($id) {
        $this->requireAuth();
        // Implementation for deleting customers
        header('Location: /customers');
        exit;
    }
}
?>
