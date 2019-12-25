<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isLoggedIn()) {
    redirect('/');
} ?>

<section class="profile">

    <?php if (isset($_GET['id'])) : ?>
        <?php if (getUserById($pdo, $_GET['id']) !== false) : ?>

            <?php $user = getUserById($pdo, $_GET['id']); ?>

            <article class="user-info">
                <div class="avatar-container">
                    <img class="avatar" src="uploads/avatars/<?php echo $user['avatar']; ?>" alt="avatar">
                </div>
                <div class="bio-container">
                    <h2><?php echo $user['username']; ?></h2>
                </div>
            </article>

            <?php if (isYourProfile()) : ?>
                <a href="/editprofile.php"><button>Edit Profile</button></a>
            <?php else : ?>
                <button>Follow</button>
            <?php endif; ?>

            <?php foreach (getPostsByUser($pdo, $_GET['id']) as $post) : ?>

                <article class="post">
                    <div class="user-container">
                        <div class="avatar-container">
                            <img class="avatar" src="/uploads/avatars/<?php echo $post['avatar']; ?>" alt="avatar">
                        </div>
                        <a href="/profile.php?id=<?php echo $post['user_id']; ?>">
                            <h2 class="username"><?php echo $post['username']; ?></h2>
                        </a>
                    </div>
                    <div class="post-image-container">
                        <img class="post-image" src="/uploads/posts/<?php echo $post['image']; ?>" alt="post image">
                    </div>
                    <div class="like-box">
                        <!-- should I add method and action for clarity? -->
                        <form class="like-form" action="">
                            <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                            <button class="like-button" type="submit">
                                <?php echo isLikedBy($pdo, $_SESSION['user']['id'], $post['id']) ? "unlike" : "like" ?>
                            </button>
                        </form>
                        <p><?php echo formatLikes(getNumberOfLikes($pdo, $post['id'])); ?></p>
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

</section>

<?php require __DIR__ . '/views/footer.php'; ?>
