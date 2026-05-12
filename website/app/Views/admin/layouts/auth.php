<main>
<div class="auth-container">
    <form method="POST" action="/admin/login">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>
</main>
<?php 
if (isset($error)) :
    $error = json_encode($error);
    echo '<script type="text/javascript">
    alert(' . $error . ');
    </script>';
endif;
?>