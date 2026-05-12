<?php
class AdminDashboardController {
    public function index() {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            require __DIR__ . '/../Views/admin/dashboard/index.php';
        } else {
            header('Location: /admin');
            exit();
        }
        exit();
    }
}
?>