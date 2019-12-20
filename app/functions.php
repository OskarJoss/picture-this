<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}

/**
 * check if SESSION user is set
 *
 * @return boolean
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Check if a value exists in the database in a specific column
 *
 * @param PDO $pdo
 * @param string $table
 * @param string $column
 * @param mixed $value
 * @return boolean
 */
function existsInDatabase(PDO $pdo, string $table, string $column, $value): bool
{
    $statement = $pdo->prepare('SELECT ' . $column . ' FROM ' . $table . ' WHERE ' . $column . ' = :value');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':value' => $value
    ]);

    if ($statement->fetch()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get all posts and the username and avatar of the poster
 *
 * @param PDO $pdo
 * @return array
 */
function getAllPosts(PDO $pdo): array
{
    $statement = $pdo->query('SELECT posts.*, users.username, users.avatar FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.date DESC');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

/**
 * Get user from database, returns array if user id exists.
 * If id doesnt exist, false is returned.
 *
 * @param PDO $pdo
 * @param integer $userId
 * @return mixed
 */
function getUserById(PDO $pdo, int $userId)
{
    $statement = $pdo->prepare('SELECT full_name, username, email, avatar FROM users WHERE id = :id');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':id' => $userId
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user;
}

/**
 * Get all posts from a user
 *
 * @param PDO $pdo
 * @param integer $userId
 * @return array
 */
function getPostsByUser(PDO $pdo, int $userId): array
{
    $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :id ORDER BY date DESC');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':id' => $userId
    ]);
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

/**
 * Check if the page belongs to the logged in user.
 * Use only if $_GET['id'] is set and user is logged in.
 *
 * @return boolean
 */
function isYourProfile(): bool
{
    return $_SESSION['user']['id'] === $_GET['id'];
}

/**
 * Get the number of likes on a post
 *
 * @param PDO $pdo
 * @param string $postId
 * @return string
 */
function getNumberOfLikes(PDO $pdo, string $postId): string
{
    $statement = $pdo->prepare('SELECT count(user_id) FROM likes WHERE post_id = :postId');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':postId' => $postId
    ]);

    $count = $statement->fetch()[0];

    return $count;
}

/**
 * check if a post is liked by a specific user
 *
 * @param PDO $pdo
 * @param string $userId
 * @param string $postId
 * @return boolean
 */
function isLikedBy(PDO $pdo, string $userId, string $postId): bool
{
    $statement = $pdo->prepare('SELECT * FROM likes WHERE user_id = :userId AND post_id = :postId');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':userId' => $userId,
        ':postId' => $postId
    ]);

    if ($statement->fetch()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Format the number of likes to a string to be displayed on the front-end
 *
 * @param string $numberOfLikes
 * @return string
 */
function formatLikes(string $numberOfLikes): string
{
    $int = intval($numberOfLikes);

    if ($int === 0) {
        return "";
    }
    if ($int === 1) {
        return "1 Like";
    }
    if ($int > 1) {
        return $numberOfLikes . " Likes";
    }
}
