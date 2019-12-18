<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $value = $_POST['id'];
    $post = [
        'postid' => $value
    ];
    echo json_encode($post);
}
