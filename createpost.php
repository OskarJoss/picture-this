<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<h1>Create Post</h1>

<?php echoErrorsAndMessages(); ?>

<form action="app/posts/store.php" method="post" enctype="multipart/form-data">

    <div class="form-section">
        <label for="image">Image:</label>
        <input class="input-file" type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required>
    </div>

    <div class="form-section">
        <label for="description">Description:</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
    </div>

    <button type="submit">Create Post</button>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
