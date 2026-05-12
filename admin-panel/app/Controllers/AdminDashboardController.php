<?php
class AdminDashboardController {
    public function index() {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            // Get counts from models
            $locale = $GLOBALS['locale'] ?? 'en';
            $countPosts = (new Posts())->getCountByLocale($locale);
            $countTags = (new ContentTags())->getCount();
            $countProducts = (new Product())->getCountByLocale($locale);
            $countOrders = (new Order())->getCount();
            $countCategories = 0; // Not implemented yet
            $countCustomers = 0; // Not implemented yet
            
            require __DIR__ . '/../Views/admin/dashboard/index.php';
        } else {
            header('Location: /');
            exit();
        }
        exit();
    }
}
?>