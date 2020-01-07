<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['id'], $_POST['reply'])) {
    //FILTER_FLAG_NO_ENCODE_QUOTES to solve problem with "'" counting as 5 characters.
    $reply = filter_var(trim($_POST['reply']), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $commentId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));

    //for the json response to show if $_POST data was valid
    $valid = true;

    if (!existsInDatabase($pdo, 'comments', 'id', $commentId)) {
        $valid = false;
        $errors = "comment doesn't exist";
        $response = [
            'valid' => $valid,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    if (strlen($reply) > 140 || strlen($reply) === 0) {
        $valid = false;
        $errors = "reply has to bee between 1-140 characters";
        $response = [
            'valid' => $valid,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement = $pdo->prepare('INSERT INTO replies (user_id, comment_id, reply) VALUES (:user_id, :comment_id, :reply)');
    if (!$statement) {
        $valid = false;
        $errors = $pdo->errorInfo();
        $response = [
            'valid' => $valid,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement->execute([
        ':user_id' => $_SESSION['user']['id'],
        ':comment_id' => $commentId,
        ':reply' => $reply
    ]);

    //get last added comment and commenter for the json response
    $statement = $pdo->prepare('SELECT * FROM replies WHERE id = :id');
    if (!$statement) {
        $valid = false;
        $errors = $pdo->errorInfo();
        $response = [
            'valid' => $valid,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement->execute([
        ':id' => $pdo->lastInsertId()
    ]);

    $reply = $statement->fetch(PDO::FETCH_ASSOC);

    $user = getUserById($pdo, $_SESSION['user']['id']);

    $response = [
        'valid' => $valid,
        'reply' => $reply,
        'user' => $user
    ];

    echo json_encode($response);
    exit;

    // echo json_encode($_POST);
}
