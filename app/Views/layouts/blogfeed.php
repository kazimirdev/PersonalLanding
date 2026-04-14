<main>
    <div class="blog-feed">
        <div class="blog-posts">
            <?php foreach ($posts as $post): ?>
                <a href="/blog/<?= $post['slug'] ?>" class="blog-post">
                    <h3><?= $post['title'] ?></h3>
                    <p><?= $post['excerpt'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
</main>