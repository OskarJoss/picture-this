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
 * @param string $dbPath
 * @return array
 */
function getAllPosts(string $dbPath = 'sqlite:app/database/picturethis.db'): array
{
    $pdo = new PDO($dbPath);
    $statement = $pdo->query('SELECT posts.*, users.username, users.avatar FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.date DESC');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

/**
 * Get user from database
 *
 * @param integer $userId
 * @param string $dbPath
 * @return array
 */
function getUserById(int $userId, string $dbPath = 'sqlite:app/database/picturethis.db'): array
{
    $pdo = new PDO($dbPath);
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
