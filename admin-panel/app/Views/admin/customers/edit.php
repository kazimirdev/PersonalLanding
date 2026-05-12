<?php

include __DIR__ . '/../layouts/head.php';
include __DIR__ . '/../layouts/header.php';

?>

<main>
    <h2>Edit Customer</h2>
    <form method="POST" action="/customers/store">
        <input type="hidden" name="id" value="">

        <div class="form-group">
            <label for="name">Customer Name:</label>
            <input type="text" id="name" name="name" value="" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3"></textarea>
        </div>

        <button type="submit" class="create-new-post admin-btn">Update Customer</button>
        <a href="/customers"><div class="admin-btn">Cancel</div></a>
    </form>
</main>

<?php
include __DIR__ . '/../layouts/script.php';
include __DIR__ . '/../layouts/footer.php';
?>
