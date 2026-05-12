<?php

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';

?>

<main>
    <h2>Products Management</h2>
    <a href="/products/create">
        <div class="create-new-post admin-btn">Create New Product</div>
    </a>
    <div class="posts-containers">
        <div class="post-item">
            <?php 
            if (isset($products) && !empty($products)) {
                foreach ($products as $product) {
                    echo '<div class="post-title">' . htmlspecialchars($product['name'] ?? $product['slug']) . '</div>';
                    echo '<div class="post-price">Price: ' . htmlspecialchars($product['price'] ?? '---') . ' ' . htmlspecialchars($product['currency'] ?? '') . '</div>';
                    echo '<div class="post-date">Created: ' . htmlspecialchars($product['created_at']) . '</div>';
                    echo '<div class="post-actions">';
                    echo '<a href="/products/' . $product['id'] . '/edit"><div class="edit-post">Edit</div></a>';
                    echo '<a href="/products/' . $product['id'] . '/delete"><div class="delete-post">Delete</div></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products found. <a href="/products/create">Create one</a></p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../layouts/script.php';
include __DIR__ . '/../layouts/footer.php';
?>
