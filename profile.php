<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<?php if (isset($_GET['id'])) : ?>
    <?php if (getUserById($pdo, $_GET['id']) !== false) : ?>
        <?php $user = getUserById($pdo, $_GET['id']); ?>
        <article class="profile">
            <div class="user-container">
                <div class="avatar-container">
                    <img src="uploads/avatars/<?php echo $user['avatar']; ?>" alt="" class="avatar">
                </div>
                <div class="bio-container">
                    <h2><?php echo $user['username']; ?></h2>
                </div>
            </div>
            <?php if (isYourProfile()) : ?>
                <button>Edit Profile</button>
            <?php else : ?>
                <button>Follow</button>
            <?php endif; ?>
        </article>
        <?php foreach (getPostsByUser($pdo, $_GET['id']) as $post) : ?>
            <article class="post">
                <div class="post-image-container">
                    <img class="post-image" src="/uploads/posts/<?php echo $post['image']; ?>" alt="post image">
                </div>
                <p><?php echo $post['description']; ?></p>
                <p><?php echo $post['date']; ?></p>
                <?php if (isYourProfile()) : ?>
                    <button>Edit Post</button>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No user found</p>
    <?php endif; ?>

<?php else : ?>
    <p>No profile selected</p>
<?php endif; ?>






<?php require __DIR__ . '/views/footer.php'; ?>
