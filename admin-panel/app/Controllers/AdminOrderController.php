<?php

class AdminOrderController {
    
    private function requireAuth() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /');
            exit();
        }
    }
    
    public function index() {
        $this->requireAuth();
        $orders = (new Order())->getAllOrders();
        require __DIR__ . '/../Views/admin/orders/index.php';
    }

    public function create() {
        $this->requireAuth();
        require __DIR__ . '/../Views/admin/orders/create.php';
    }

    public function edit($id) {
        $this->requireAuth();
        $order = (new Order())->getOrderById($id);
        require __DIR__ . '/../Views/admin/orders/edit.php';
    }

    public function store() {
        $this->requireAuth();
        // Implementation for creating/updating orders
        header('Location: /orders');
        exit;
    }

    public function delete($id) {
        $this->requireAuth();
        $orderModel = new Order();
        $orderModel->deleteById($id);
        header('Location: /orders');
        exit;
    }
}

?>