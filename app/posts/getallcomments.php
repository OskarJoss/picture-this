<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $postId = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING));
    $valid = true;

    if (!existsInDatabase($pdo, 'posts', 'id', $postId)) {
        $valid = false;
        $errors = "post doesn't exist";
        $response = [
            'valid' => $valid,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }

    $statement = $pdo->prepare('SELECT * FROM comments WHERE post_id = :postId ORDER BY date ASC');
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
        ':postId' => $postId
    ]);

    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

    //add username and avatar of commenter to each comment
    for ($i = 0; $i < count($comments); $i++) {
        $commenter = getUserById($pdo, $comments[$i]['user_id']);
        $comments[$i]['avatar'] = $commenter['avatar'];
        $comments[$i]['username'] = $commenter['username'];
    }

    $response = [
        'valid' => $valid,
        'comments' => $comments
    ];

    echo json_encode($response);
    exit;
}

redirect('/');