<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../book/bookHandler.php';

    $bookData = file_get_contents('php://input');
    $bookData = json_decode($bookData, true);
    echo newBookTransact($pdo, $bookData);
?>