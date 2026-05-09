<?php

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';

?>

<main>
    <h2>Customers Management</h2>
    <a href="/customers/create">
        <div class="create-new-post admin-btn">Create New Customer</div>
    </a>
    <div class="posts-containers">
        <div class="post-item">
            <?php 
            if (isset($customers) && !empty($customers)) {
                foreach ($customers as $customer) {
                    echo '<div class="post-title">' . htmlspecialchars($customer['name'] ?? '') . '</div>';
                    echo '<div class="post-email">Email: ' . htmlspecialchars($customer['email'] ?? '---') . '</div>';
                    echo '<div class="post-phone">Phone: ' . htmlspecialchars($customer['phone'] ?? '---') . '</div>';
                    echo '<div class="post-date">Created: ' . htmlspecialchars($customer['created_at'] ?? '') . '</div>';
                    echo '<div class="post-actions">';
                    echo '<a href="/customers/' . $customer['id'] . '/edit"><div class="edit-post">Edit</div></a>';
                    echo '<a href="/customers/' . $customer['id'] . '/delete"><div class="delete-post">Delete</div></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No customers found. <a href="/customers/create">Create one</a></p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../layouts/script.php';
include __DIR__ . '/../layouts/footer.php';
?>
