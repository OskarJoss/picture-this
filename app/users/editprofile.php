<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];

    if (count($_FILES) > 1) {
        $_SESSION['errors'] = "You can only upload 1 image at a time";
        redirect('/editprofile.php');
    }

    if ($image['type'] !== 'image/jpeg' && $image['type'] !== 'image/jpg' && $image['type'] !== 'image/png') {
        $_SESSION['errors'] = "The image filetype is not valid";
        redirect('/editprofile.php');
    }

    if ($image['size'] > '3000000') {
        $_SESSION['errors'] = "The image file is too big, 3mb is max";
        redirect('/editprofile.php');
    }

    $fileExt = '.' . explode('/', $image['type'])[1];
    $fileName = uniqid("", true) . $fileExt;
    $id = $_SESSION['user']['id'];

    if (!move_uploaded_file($image['tmp_name'], '../../uploads/avatars/' . $fileName)) {
        $_SESSION['errors'] = "Something went wrong with the upload";
        redirect('/editprofile.php');
    }

    $user = getUserById($pdo, $id);
    //remove old avatar from uploads unless it's the default avatar pic.
    if ($user['avatar'] !== 'default_avatar.jpeg') {
        unlink(__DIR__ . '/../../uploads/avatars/' . $user['avatar']);
    }

    $statement = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':avatar' => $fileName,
        ':id' => $_SESSION['user']['id']
    ]);

    redirect('/editprofile.php');
}

redirect('/');
