<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

$id = $_SESSION['user']['id'];

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $user = getUserById($pdo, $id);

    if (!isValidImage($image)) {
        redirect('/editprofile.php');
    }

    $fileName = createFileName($image['type']);

    if (!move_uploaded_file($image['tmp_name'], '../../uploads/avatars/' . $fileName)) {
        $_SESSION['errors'] = "Something went wrong with the upload";
        redirect('/editprofile.php');
    }

    //remove old avatar from uploads unless it's the default avatar pic.
    if ($user['avatar'] !== 'default_avatar.jpeg') {
        unlink(__DIR__ . '/../../uploads/avatars/' . $user['avatar']);
    }

    $statement = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':avatar' => $fileName,
        ':id' => $id
    ]);

    $_SESSION['messages'] = "Avatar updated";

    redirect('/editprofile.php');
}

if (isset($_POST['username'])) {
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));

    if (!isValidUsername($pdo, $username)) {
        redirect('/editprofile.php');
    }

    $statement = $pdo->prepare('UPDATE users SET username = :username WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':username' => $username,
        ':id' => $id
    ]);

    $_SESSION['messages'] = "Username updated";

    redirect('/editprofile.php');
}

if (isset($_POST['biography'])) {
    //FILTER_FLAG_NO_ENCODE_QUOTES to solve problem with "'" counting as 5 characters.
    $biography = filter_var(trim($_POST['biography']), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if (strlen($biography) > 140) {
        $_SESSION['errors'] = "Biography is too long, 140 characters is max";
        redirect('/editprofile.php');
    }

    if (strlen($biography) === 0) {
        $biography = NULL;
    }

    $statement = $pdo->prepare('UPDATE users SET biography = :biography WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':biography' => $biography,
        ':id' => $id
    ]);

    $_SESSION['messages'] = "bio updated";

    redirect('/editprofile.php');
}

if (isset($_POST['email'])) {
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));

    if (existsInDatabase($pdo, 'users', 'email', $email)) {
        $_SESSION['errors'] = "email is already registered";
        redirect('/');
    }

    $statement = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':email' => $email,
        ':id' => $id
    ]);

    $_SESSION['messages'] = "email updated";

    redirect('/editprofile.php');
}

if (isset($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmNewPassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if ($newPassword !== $confirmNewPassword) {
        $_SESSION['errors'] = "passwords are not the same";
        redirect('/editprofile.php');
    }

    if ($oldPassword === $newPassword) {
        $_SESSION['errors'] = "old and new passwords are the same";
        redirect('/editprofile.php');
    }

    if (strlen($newPassword) < 6) {
        $_SESSION['errors'] = 'password has to be at least 6 characters long';
        redirect('/editprofile.php');
    }

    $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ':id' => $id
    ]);

    $_SESSION['messages'] = "password updated";

    redirect('/editprofile.php');
}

redirect('/');
