<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $postId = intval(trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING)));
    $userId = intval($_SESSION['user']['id']);

    $statement = $pdo->prepare('SELECT * FROM likes WHERE user_id = :userId AND post_id = :postId');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':userId' => $userId,
        ':postId' => $postId
    ]);
    // if like doesent exist, add it. If it exists, remove it.
    if ($statement->fetch() === false) {
        $insertStatement = $pdo->prepare('INSERT INTO likes (user_id, post_id) VALUES (:userId, :postId)');
        if (!$insertStatement) {
            die(var_dump($pdo->errorInfo()));
        }
        $insertStatement->execute([
            ':userId' => $userId,
            ':postId' => $postId
        ]);
        // response to the front-end
        $response = ['action' => 'liked'];
        echo json_encode($response);
    } else {
        $deleteStatement = $pdo->prepare('DELETE FROM likes WHERE user_id = :userId AND post_id = :postId');
        if (!$deleteStatement) {
            die(var_dump($pdo->errorInfo()));
        }
        $deleteStatement->execute([
            ':userId' => $userId,
            ':postId' => $postId
        ]);
        // response to the front-end
        $response = ['action' => 'unliked'];
        echo json_encode($response);
    }
}
