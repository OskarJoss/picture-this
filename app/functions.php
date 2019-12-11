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

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

/**
 * Check if a value exists in the database
 *
 * @param [type] $pdo
 * @param string $table
 * @param string $column
 * @param [type] $value
 * @return boolean
 */
function existsInDatabase($pdo, string $table, string $column, $value): bool
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
