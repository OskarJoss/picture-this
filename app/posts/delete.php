<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

$id = $_SESSION['user']['id'];

if (isset($_POST['id'])) {
    $post = getPostById($pdo, $_POST['id']);

    if ($post['user_id'] !== $id) {
        $_SESSION['errors'] = 'Not your post';
        redirect('/');
    }

    $statement = $pdo->prepare('DELETE FROM posts WHERE id = :postId');
    pdoErrorInfo($pdo, $statement);

    unlink(__DIR__ . '/../../uploads/posts/' . $post['image']);

    $statement->execute([
        ':postId' => $post['id']
    ]);

    $_SESSION['messages'] = 'post deleted';

    redirect('/profile.php?id=' . $id);
}

redirect('/');
