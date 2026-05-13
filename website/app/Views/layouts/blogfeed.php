<main>
    <div class="content-feed">
        <?php foreach ($posts as $post): ?>
        <a href="/content/<?= $post['slug'] ?>" class="blog-post">
        <div class="content-post">
                <h3><?= $post['title'] ?></h3>
                <?php if ($post['image_preview_url']): ?>
                    <img src="<?= $post['image_preview_url'] ?>" alt="Preview Image" class="blog-post-preview">
                <?php endif; ?>
                <?php if (strlen($post['content_html'] ?? '') > 200): ?>
                    <p><?= substr($post['content_html'], 0, 200) ?>...</p>
                <?php else: ?>
                    <p><?= substr($post['content_html'], 0, 128) ?></p>
                <?php endif; ?>
        </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>