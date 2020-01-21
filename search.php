<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<h1>Search</h1>
<form action="app/users/search.php" method="post" class="form-section search">
    <input type="text" name="search" placeholder="John Doe">
</form>
<div class="error"></div>
<ul class="search-result">

</ul>

<?php require __DIR__ . '/views/footer.php'; ?>
