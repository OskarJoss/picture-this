<?php

// add validate filename, characters and length

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

if (isset($_POST['description'], $_FILES['image'])) {
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];

    if (count($_FILES) > 1) {
        $_SESSION['errors'] = "You can only upload 1 image in a post";
        redirect('/createpost.php');
    }

    if ($image['type'] !== 'image/jpeg' && $image['type'] !== 'image/jpg' && $image['type'] !== 'image/png') {
        $_SESSION['errors'] = "The image filetype is not valid";
        redirect('/createpost.php');
    }

    if ($image['size'] > '3000000') {
        $_SESSION['errors'] = "The image file is too big, 3mb is max";
        redirect('/createpost.php');
    }

    $fileExt = '.' . explode('/', $image['type'])[1];
    $fileName = uniqid("", true) . $fileExt;
    $id = $_SESSION['user']['id'];

    if (!move_uploaded_file($image['tmp_name'], '../../uploads/posts/' . $fileName)) {
        $_SESSION['errors'] = "Something went wrong with the upload";
        redirect('/createpost.php');
    }

    $statement = $pdo->prepare('INSERT INTO posts (user_id, image, description) VALUES (:user_id, :image, :description)');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $id,
        ':image' => $fileName,
        ':description' => $description
    ]);

    //temporary redirect
    $_SESSION['messages'] = "post uploaded!";
    redirect('/createpost.php');
}

redirect('/');
