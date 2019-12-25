<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<section class="edit-profile">

    <h1>Edit Profile</h1>


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

    <?php $user = getUserById($pdo, $_SESSION['user']['id']); ?>

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


</section>

<?php require __DIR__ . '/views/footer.php'; ?>
