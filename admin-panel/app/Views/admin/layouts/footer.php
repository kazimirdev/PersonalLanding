<?php
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo '<footer>';
    echo '<p>kazimir.dev &copy; ' . date('Y') . ' </p>';
} else {
    echo '<footer class="admin-authed">';
    echo '<a href="/dashboard"><div>Dashboard</div></a>';
    echo '<a href="/logout"><div>Logout</div></a>';
    echo '</footer>';
}
?>
</footer>