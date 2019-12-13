<?php require __DIR__ . '/views/header.php'; ?>


<form action="app/posts/store.php.php" method="post">
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

    <button type="submit">Create Post</button>
</form>





<?php require __DIR__ . '/views/footer.php'; ?>
