<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<h1>PROFILE</h1>





<?php require __DIR__ . '/views/footer.php'; ?>
