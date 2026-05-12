<?php 
    $page_title_head = "$errorCode | Admin";
    $additional_head = '<link rel="stylesheet" href="/css/hide_page_width.css">'; 
    include __DIR__ . '/../admin/layouts/head.php';
    include __DIR__ . '/../admin/layouts/header.php'; 
    ?>
    <main>
        <h1>HTTP status code – <?php echo $errorCode; ?></h1>
        <p><?php echo $errorDescription; ?>.</p></br>
        <p><a href="/dashboard">[Back to dashboard]</a></p>
    </main>
    <?php include __DIR__ . '/../admin/layouts/footer.php'; ?>
</body>
</html>
