<main>
    <div class="content-feed">
        <?php foreach ($posts as $post): ?>
        <a href="/content/<?= $post['slug'] ?>" class="blog-post">
            <div class="content-post">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <?php if ($post['image_preview_url']): ?>
                    <img src="<?= htmlspecialchars($post['image_preview_url']) ?>" alt="Preview Image" class="blog-post-preview">
                <?php endif; ?>
                <?php if (!empty($post['content_preview'])): ?>
                    <p><?= htmlspecialchars($post['content_preview']) ?></p>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>