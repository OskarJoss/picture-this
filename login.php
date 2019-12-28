<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Login</h1>

    <?php echoErrorsAndMessages(); ?>

    <form action="app/users/login.php" method="post">
        <div class="form-section">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="example@mail.com" required>
            <small>Please provide the your email address.</small>
        </div>

        <div class="form-section">
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <small>Please provide the your password (passphrase).</small>
        </div>

        <button type="submit">Login</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
