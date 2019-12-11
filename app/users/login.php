<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':email' => $email
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user === false) {
        //add error to session
        redirect('/login.php');
    }

    if (password_verify($_POST['password'], $user['password']) === false) {
        //add error to session
        redirect('/login.php');
    }

    if (password_verify($_POST['password'], $user['password']) === true) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        redirect('/');
    }
}

redirect('/');
