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

    $status = true;

    if (strlen($comment) > 5) {
        $status = false;
        $errors = "comment is too long";
        $response = [
            'status' => $status,
            'errors' => $errors
        ];
        echo json_encode($response);
        exit;
    }




    $response = [
        'status' => $status,
        'postId' => $postId
    ];

    echo json_encode($response);
}
