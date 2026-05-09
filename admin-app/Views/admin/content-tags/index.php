<?php

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';

?>

<main>
    <h2>Content Tags Management</h2>
    <a href="/content-tags/create">
        <div class="create-new-post admin-btn">Create New Tag</div>
    </a>
    <div class="posts-containers">
        <div class="post-item">
            <?php 
            if (isset($tags) && !empty($tags)) {
                foreach ($tags as $tag) {
                    echo '<div class="post-title">' . htmlspecialchars($tag['name']) . '</div>';
                    echo '<div class="post-actions">';
                    echo '<a href="/content-tags/' . $tag['id'] . '/edit"><div class="edit-post">Edit</div></a>';
                    echo '<a href="/content-tags/' . $tag['id'] . '/delete"><div class="delete-post">Delete</div></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tags found. <a href="/content-tags/create">Create one</a></p>';
            }
            ?>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../layouts/script.php';
include __DIR__ . '/../layouts/footer.php';
?>
