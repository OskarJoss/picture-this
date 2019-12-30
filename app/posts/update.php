<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

$id = $_SESSION['user']['id'];

if (isset($_FILES['image'], $_POST['id'])) {
    $image = $_FILES['image'];
    $post = getPostById($pdo, $_POST['id']);

    if ($post['user_id'] !== $id) {
        $_SESSION['errors'] = 'Not your post';
        redirect('/');
    }

    if (!isValidImage($image)) {
        redirect('/editpost.php?id=' . $post['id']);
    }

    $fileName = createFileName($image['type']);

    if (!move_uploaded_file($image['tmp_name'], '../../uploads/posts/' . $fileName)) {
        $_SESSION['errors'] = "Something went wrong with the upload";
        redirect('/editpost.php?id=' . $post['id']);
    }

    unlink(__DIR__ . '/../../uploads/posts/' . $post['image']);

    $statement = $pdo->prepare('UPDATE posts SET image = :fileName WHERE id = :postId');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':fileName' => $fileName,
        ':postId' => $post['id']
    ]);

    $_SESSION['messages'] = 'image updated';

    redirect('/editpost.php?id=' . $post['id']);
}

if (isset($_POST['description'], $_POST['id'])) {
    //FILTER_FLAG_NO_ENCODE_QUOTES to solve problem with "'" counting as 5 characters.
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $post = getPostById($pdo, $_POST['id']);

    if ($post['user_id'] !== $id) {
        $_SESSION['errors'] = 'Not your post';
        redirect('/');
    }

    if (strlen($description) > 140) {
        $_SESSION['errors'] = "Description is too long, 140 characters is max";
        redirect('/editpost.php?id=' . $post['id']);
    }

    $statement = $pdo->prepare('UPDATE posts SET description = :description WHERE id = :postId');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':description' => $description,
        ':postId' => $post['id']
    ]);

    $_SESSION['messages'] = 'Description updated';

    redirect('/editpost.php?id=' . $post['id']);
}

redirect('/');
