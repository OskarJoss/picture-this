<nav>
    <ul class="nav-list">
        <li>
            <a class="nav-link" href="/index.php">Home</a>
        </li>

        <?php if (isLoggedIn()) : ?>

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
