<?php require __DIR__ . '/views/header.php'; ?>

<?php echoErrorsAndMessages(); ?>

<?php if (isLoggedIn()) : ?>

    <h1>Welcome <?php echo $_SESSION['user']['username']; ?></h1>

    <?php $user = getUserById($pdo, $_SESSION['user']['id']); ?>
    <div class="wrapper">
        <?php foreach (getAllPosts($pdo) as $post) : ?>
            <article class="post">
                <!-- user and date -->
                <div class="user-container">
                    <a href="/profile.php?id=<?php echo $post['user_id']; ?>">
                        <div class="avatar-container">
                            <img class="avatar" src="/uploads/avatars/<?php echo $post['avatar']; ?>" alt="avatar">
                        </div>
                    </a>
                    <a href="/profile.php?id=<?php echo $post['user_id']; ?>">
                        <h2 class="username"><?php echo $post['username']; ?></h2>
                    </a>
                    <p><?php echo $post['date']; ?></p>
                </div>
                <!-- post image -->
                <div class="post-image-container">
                    <img class="post-image" src="/uploads/posts/<?php echo $post['image']; ?>" alt="post image">
                </div>
                <!-- likes -->
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
                <!-- description -->
                <?php if (strlen($post['description']) !== 0) : ?>
                    <p><?php echo $post['description']; ?></p>
                <?php endif; ?>
                <!-- comments -->
                <?php $numberOfComments = getNumberOfComments($pdo, $post['id']); ?>
                <?php if ($numberOfComments > 2) : ?>
                    <form class="show-comments-form" action="">
                        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                        <button class="show-comments-button">show all <?php echo $numberOfComments ?> comments</button>
                    </form>
                <?php endif; ?>
                <ul class="comment-list">
                    <?php if (count(getLatestComments($pdo, $post['id'])) !== 0) : ?>
                        <?php foreach (getLatestComments($pdo, $post['id']) as $comment) : ?>
                            <?php $commenter = getUserById($pdo, $comment['user_id']); ?>
                            <article class="comment">
                                <li class="comment-container">
                                    <a href="/profile.php?id=<?php echo $comment['user_id']; ?>">
                                        <div class="avatar-container">
                                            <img class="avatar" src="/uploads/avatars/<?php echo $commenter['avatar']; ?>" alt="avatar">
                                        </div>
                                    </a>
                                    <p><a href="/profile.php?id=<?php echo $comment['user_id']; ?>"><span><?php echo $commenter['username']; ?></span></a><?php echo $comment['comment']; ?></p>
                                </li>
                                <!-- replies -->
                                <div class="reply-buttons-container">
                                    <button class="reply-button">reply/show X replies</button>
                                    <?php if (isYourComment($pdo, $_SESSION['user']['id'], $comment['id'])) : ?>
                                        <button>edit comment</button>
                                    <?php endif; ?>
                                </div>
                                <ul class="reply-list"></ul>
                                <form class="reply-form" action="" method="post">
                                    <div class="avatar-container">
                                        <img class="avatar" src="/uploads/avatars/<?php echo $user['avatar']; ?>" alt="avatar">
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                    <textarea name="reply" cols="45" rows="1" maxlength="140" placeholder="reply..." required></textarea>
                                    <button type="submit">Send</button>
                                </form>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <!-- comment input -->
                <form class="comment-form" action="" method="post">
                    <div class="avatar-container">
                        <img class="avatar" src="/uploads/avatars/<?php echo $user['avatar']; ?>" alt="avatar">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <textarea name="comment" cols="45" rows="1" maxlength="140" placeholder="Leave a comment..." required></textarea>
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
