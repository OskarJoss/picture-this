<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['comment'], $_POST['id'])) {
    //FILTER_FLAG_NO_ENCODE_QUOTES to solve problem with "'" counting as 5 characters.
    $comment = filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $postId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
    $user = getUserById($pdo, $_SESSION['user']['id']);

    $status = true;

    if (!existsInDatabase($pdo, 'posts', 'id', $postId)) {
        $status = false;
        $errors = "post doesn't exist";
        $response = [
            'status' => $status,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    if (strlen($comment) > 140 || strlen($comment) === 0) {
        $status = false;
        $errors = "comment has to bee between 1-140 characters";
        $response = [
            'status' => $status,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement = $pdo->prepare('INSERT INTO comments (user_id, post_id, comment) VALUES (:user_id, :post_id, :comment)');
    if (!$statement) {
        $status = false;
        $errors = $pdo->errorInfo();
        $response = [
            'status' => $status,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':post_id' => $postId,
        ':comment' => $comment
    ]);

    //get last added comment and commenter for the json response
    $statement = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
    pdoErrorInfo($pdo, $statement);

    $statement->execute([
        ':id' => $pdo->lastInsertId()
    ]);

    $comment = $statement->fetch(PDO::FETCH_ASSOC);

    $user = getUserById($pdo, $_SESSION['user']['id']);

    $response = [
        'status' => $status,
        'comment' => $comment,
        'user' => $user
    ];

    echo json_encode($response);
    exit;
}

redirect('/');
