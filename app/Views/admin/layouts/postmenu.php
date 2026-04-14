<main>
    <h2>Post's control page</h2>
    <div class="posts-containers">
        <a href="/admin/blog-posts/create">
            <div class="create-new-post admin-btn">Create new post</div>
        </a>
        <div class="post-item">
            <?php 
            foreach ($posts as $post) {
                echo '<div class="post-title">' . htmlspecialchars($post['title']) . '</div>';
                echo '<div class="post-actions">';
                echo '<div class="show-post">Show on website</div>';
                echo '<div class="edit-post">Edit</div>';
                echo '<div class="delete-post">Delete</div>';
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</main>