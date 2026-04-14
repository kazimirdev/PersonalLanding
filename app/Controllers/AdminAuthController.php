<?php
class AdminAuthController {
    public function index() {
        require __DIR__ . '/../Views/admin/auth/login.php';
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $config = require __DIR__ . '/../../config/admin.php';
        $adminUsername = $config['admin_username'];
        $adminPassword = $config['admin_password'];

        if ($username === $adminUsername && $password === $adminPassword) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: /admin/dashboard');
            exit;
        } else {
            $error = 'Invalid username or password';
            require __DIR__ . '/../Views/admin/auth/login.php';
        }
    }
    public function logout() {
        session_destroy();
        header('Location: /admin');
        exit;
    }
}

?>