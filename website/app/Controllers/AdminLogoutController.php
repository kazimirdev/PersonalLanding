<?php
class AdminLogoutController {
    public function index() {
        session_destroy();
        header('Location: /admin');
        exit;
    }
}
?>