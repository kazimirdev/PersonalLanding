<?php 
    $page_title_head = "$errorCode | kazimir.dev";
    $additional_head = '<link rel="stylesheet" href="/css/hide_page_width.css">'; 
    include __DIR__ . '/../layouts/head.php';
    include __DIR__ . '/../layouts/header.php'; 
    ?>
    <main>
        <h1>HTTP status code – <?php echo $errorCode; ?></h1>
        <p><?php echo $errorDescription; ?>.</p></br>
        <p><a href="/">[Back to home]</a></p>
    </main>
    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>
