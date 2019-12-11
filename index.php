<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) : ?>
    <h1>Create account</h1>
<?php else : ?>
    <article>
        <h1>Logged in</h1>
        <p>See the posts below</p>
    </article>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
