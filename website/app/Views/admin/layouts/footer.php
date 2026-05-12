<?php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo '<footer>';
    echo '<p>kazimir.dev &copy; ' . date('Y') . ' </p>';
} else {
    echo '<footer class="admin-authed">';
    echo '<a href="/admin/dashboard"><div>Dashboard</div></a>';
    echo '<a href="/admin/logout"><div>Logout</div></a>';
    echo '</footer>';
}
?>
</footer>