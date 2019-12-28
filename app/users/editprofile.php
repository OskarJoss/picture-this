<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['image'])) {
    $_SESSION['errors'] = "test yozaaa";
    $_SESSION['messages'] = "test yo";
    redirect('/editprofile.php');
}
