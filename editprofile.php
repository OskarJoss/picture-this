<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<section class="edit-profile">

    <h1>Edit Profile</h1>

    <?php echoErrorsAndMessages(); ?>

    <?php $user = getUserById($pdo, $_SESSION['user']['id']); ?>

    <article>
        <div class="avatar-container">
            <img class="avatar" src="/uploads/avatars/<?php echo $user['avatar'] ?>" alt="avatar">
        </div>
        <button class="show-form-button">Change Avatar</button>
        <form class="edit-profile-avatar" action="app/users/editprofile.php" method="post" enctype="multipart/form-data">
            <div class="form-section">
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" required>
                <button type="submit">Save</button>
            </div>
        </form>
    </article>

    <article>
        <div class="flex-row">
            <p>Username:</p>
            <p><?php echo $user['username']; ?></p>
            <button class="show-form-button">Edit</button>
        </div>
        <form class="edit-profile-username" action="app/users/editprofile.php" method="post">
            <div class="form-section">
                <label for="username">New Username:</label>
                <input type="text" name="username" id="username" required>
                <button type="submit">Save</button>
            </div>
        </form>
    </article>


</section>

<?php require __DIR__ . '/views/footer.php'; ?>
