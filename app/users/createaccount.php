<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['fullName'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirmPassword'])) {
    $fullName = trim(filter_var($_POST['fullName'], FILTER_SANITIZE_STRING));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['errors'] = "passwords are not the same";
        redirect('/');
    }

    //check if email i available

    if (existsInDatabase($pdo, 'users', 'email', $email)) {
        $_SESSION['errors'] = "email is already registered";
        redirect('/');
    }

    if (existsInDatabase($pdo, 'users', 'username', $username)) {
        $_SESSION['errors'] = "username is already registered";
        redirect('/');
    }

    echo "dags o lägga in i databasen";

    // $statement = $pdo->prepare('SELECT email FROM users WHERE email = :email');
    // if (!$statement) {
    //     die(var_dump($pdo->errorInfo()));
    // }
    // $statement->execute([
    //     ':email' => $email
    // ]);

    // if ($statement->fetch(PDO::FETCH_ASSOC)) {
    //     $_SESSION['errors'] = "email is already registered";
    // }
}


// redirect('/');
