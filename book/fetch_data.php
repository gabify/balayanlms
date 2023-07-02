<?php
    //Will add search later :)
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../book/bookHandler.php';

    if(isset($_GET['limit'])){
        $limit = htmlspecialchars($_GET['limit']);
        $books = getAllBooks($pdo, 1, $limit);
        echo json_encode($books);
    }
?>