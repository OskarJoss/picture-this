<?php
// Always start by loading the default application setup.
require __DIR__ . '/../app/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $config['title']; ?></title>

    <link rel="stylesheet" href="https://unpkg.com/sanitize.css">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <link rel="stylesheet" href="/assets/styles/nav.css">
    <link rel="stylesheet" href="/assets/styles/post.css">
    <link rel="stylesheet" href="/assets/styles/profile.css">
    <link rel="stylesheet" href="/assets/styles/editprofile.css">
</head>

<body>
    <?php require __DIR__ . '/navigation.php'; ?>

    <div>
