<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (
    isset($_POST['fullName'],
    $_POST['email'],
    $_POST['username'],
    $_POST['password'],
    $_POST['confirmPassword'])
) {
    $fullName = trim(filter_var($_POST['fullName'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['errors'] = "passwords are not the same";
        redirect('/');
    }

    if (existsInDatabase($pdo, 'users', 'email', $email)) {
        $_SESSION['errors'] = "email is already registered";
        redirect('/');
    }

    if (existsInDatabase($pdo, 'users', 'username', $username)) {
        $_SESSION['errors'] = "username is already registered";
        redirect('/');
    }

    $statement = $pdo->prepare('INSERT INTO users (full_name, username, email, password) VALUES (:fullname, :username, :email, :password)');

    $statement->execute([
        ':fullname' => $fullName,
        ':username' => $username,
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    //login the user when account is created
    $_SESSION['user'] = [
        'id' => $pdo->lastInsertId(),
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email
    ];

    redirect('/');
}

redirect('/');
