<main>
    <h2>Post's control page</h2>
        <a href="/content/create">
            <div class="create-new-post admin-btn">Create new post</div>
        </a>
    <div class="posts-containers">
        
        <div class="post-item">
            <?php 
            foreach ($posts as $post) {
                echo '<div class="post-title">' . htmlspecialchars($post['title']) . '</div>';
                echo '<div class="post-actions">';
                echo '<a href="/content/' . $post['slug'] . '"><div class="show-post">Show on website</div></a>';
                echo '<a href="/content/' . $post['id'] . '/edit"><div class="edit-post">Edit</div></a>';
                echo '<a href="/content/' . $post['id'] . '/delete"><div class="delete-post">Delete</div></a>';
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</main>