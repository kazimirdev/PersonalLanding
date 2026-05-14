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
                if (!empty($post['content_preview'])) {
                    echo '<div class="post-preview">' . htmlspecialchars($post['content_preview']) . '</div>';
                }
                echo '<div class="post-actions">';
                echo '<a href="http://localhost:8080/content/' . htmlspecialchars($post['slug']) . '" target="_blank"><div class="show-post">Show on website</div></a>';
                echo '<a href="/content/' . $post['id'] . '/edit"><div class="edit-post">Edit</div></a>';
                echo '<a href="/content/' . $post['id'] . '/delete"><div class="delete-post">Delete</div></a>';
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
</main>