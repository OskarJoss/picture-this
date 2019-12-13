<?php

declare(strict_types=1);

if (!isLoggedIn()) {
    redirect('/');
}

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

// redirect('/');
