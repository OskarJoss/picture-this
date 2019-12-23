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
</section>


<?php require __DIR__ . '/views/footer.php'; ?>
