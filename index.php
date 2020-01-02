<?php require __DIR__ . '/views/header.php'; ?>

<?php echoErrorsAndMessages(); ?>

<?php if (isLoggedIn()) : ?>

    <h1>Welcome <?php echo $_SESSION['user']['username']; ?></h1>

    <div class="wrapper">
        <?php foreach (getAllPosts($pdo) as $post) : ?>
            <article class="post">
                <div class="user-container">
                    <div class="avatar-container">
                        <img class="avatar" src="/uploads/avatars/<?php echo $post['avatar']; ?>" alt="avatar">
                    </div>
                    <a href="/profile.php?id=<?php echo $post['user_id']; ?>">
                        <h2 class="username"><?php echo $post['username']; ?></h2>
                    </a>
                    <p><?php echo $post['date']; ?></p>
                </div>
                <div class="post-image-container">
                    <img class="post-image" src="/uploads/posts/<?php echo $post['image']; ?>" alt="post image">
                </div>
                <div class="like-box">
                    <!-- should I add method and action for clarity? -->
                    <form class="like-form" action="">
                        <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                        <button class="like-button" type="submit">
                            <?php echo isLikedBy($pdo, $_SESSION['user']['id'], $post['id']) ? "unlike" : "like"; ?>
                        </button>
                    </form>
                    <p><?php echo formatLikes(getNumberOfLikes($pdo, $post['id'])); ?></p>
                </div>
                <p><?php echo $post['description']; ?></p>
                <ol class="comment-list"></ol>
                <?php $user = getUserById($pdo, $_SESSION['user']['id']); ?>
                <form class="comment-form" action="" method="post">
                    <div class="avatar-container">
                        <img class="avatar" src="/uploads/avatars/<?php echo $user['avatar']; ?>" alt="avatar">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <textarea name="comment" cols="45" rows="1" placeholder="Leave a comment..."></textarea>
                    <button type="submit">Send</button>
                </form>
            </article>
        <?php endforeach; ?>

    <?php else : ?>

        <h1>Welcome to picture this!</h1>
        <h2>Create account:</h2>

        <form action="app/users/createaccount.php" method="post">
            <div class="form-section">
                <label for="fullName">Full Name</label>
                <input type="text" name="fullName" id="fullName" required>
            </div>
            <div class="form-section">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-section">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-section">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-section">
                <label for="confirmPassword">confirm password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>
            </div>
            <button type="submit">Create account</button>
        </form>
    </div>

<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
