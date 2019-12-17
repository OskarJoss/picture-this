<nav>
    <ul class="nav-list">
        <li>
            <a href="/index.php">Home</a>
        </li>

        <?php if (isLoggedIn()) : ?>

            <li>
                <a href="/createpost.php">Create Post</a>
            </li>

            <li>
                <a href="/profile.php?id=<?php echo $_SESSION['user']['id']; ?>">Profile</a>
            </li>

            <li>
                <a href="app/users/logout.php">Log out</a>
            </li>

        <?php else : ?>
            <li>
                <a href="/login.php">Login</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
