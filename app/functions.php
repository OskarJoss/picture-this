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

function getAllPosts(string $dbPath = 'sqlite:app/database/picturethis.db'): array
{
    $pdo = new PDO($dbPath);
    $statement = $pdo->query('SELECT * FROM posts');
    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

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
