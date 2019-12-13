<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (!isLoggedIn()) {
    redirect('/');
}


if (isset($_POST['description'], $_FILES['image'])) {
    $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
    $image = $_FILES['image'];
    // $date = date(DATE_ATOM);

    if (count($_FILES) > 1) {
        $_SESSION['errors'] = "You can only upload 1 image in a post";
        redirect('/createpost.php');
    }

    if ($image['type'] !== 'image/jpeg' && $image['type'] !== 'image/jpg' && $image['type'] !== 'image/png') {
        $_SESSION['errors'] = "The image filetype is not valid";
        redirect('/createpost.php');
    }

    if ($image['size'] > '3000000') {
        $_SESSION['errors'] = "The image file is too big, 3mb is max";
        redirect('/createpost.php');
    }

    //fixa filename uuid, spara filnamnet i databasen
    //databasen har automatisk date('now', 'localtime')
    //lägg filen i uplods/posts eller nått
    $fileName = date('Ymd');
    move_uploaded_file($image['tmp_name'], '../../uploads/' . $fileName . ".jpg");
}



// array(5) { ["name"]=> string(36) "146a4f991a319d73a717baeb54270d5a.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(66) "/private/var/folders/b7/jzmb2fls2ysdnr8v6l4z1ghr0000gn/T/phpezo7PW" ["error"]=> int(0) ["size"]=> int(282194) }

// redirect('/');
