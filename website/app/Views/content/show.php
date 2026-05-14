<?php 
include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';
?>

<main>
    <div class="content-post-single">
        <article>
            <?php if ($post['image_preview_url']): ?>
                <img src="<?= htmlspecialchars($post['image_preview_url']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="post-featured-image">
            <?php endif; ?>
            <h1><?= htmlspecialchars($post['title']) ?></h1>
            <div class="post-meta">
                <span class="post-date"><?= isset($post['created_at']) ? htmlspecialchars($post['created_at']) : htmlspecialchars($post['updated_at']) ?></span>
            </div>
            <div class="post-content">
                <?= $post['content_html'] ?>
            </div>
        </article>
    </div>
</main>

<?php 
include __DIR__ . '/../layouts/footer.php';
?>
