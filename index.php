<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) : ?>
    <h1>Welcome to picture this!</h1>
    <h2>Create account:</h2>

    <p>
        <?php if (isset($_SESSION['errors'])) {
                echo $_SESSION['errors'];
                unset($_SESSION['errors']);
            } ?>
    </p>
    <p>
        <?php if (isset($_SESSION['messages'])) {
                echo $_SESSION['messages'];
                unset($_SESSION['messages']);
            } ?>
    </p>

    <form action="app/users/createaccount.php" method="post">
        <div class="form-section">
            <label for="fullName">Full Name</label>
            <input type="text" name="fullName" id="fullName" required>
        </div>
        <div class="form-section">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-section">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-section">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div class="form-section">
            <label for="confirmPassword">confirm password:</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>
        </div>

        <button type="submit">Create account</button>
    </form>
<?php else : ?>
    <article>
        <h1>Welcome <?php echo $_SESSION['user']['username']; ?></h1>
        <p>See the posts below</p>
    </article>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
