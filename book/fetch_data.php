<?php
    //Will add search later :)
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../book/bookHandler.php';

    $books = getAllBooks($pdo, 1, 10);
    echo json_encode($books);
?>