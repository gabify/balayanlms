<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '/xampp/htdocs/balayanlms/book/bookHandler.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $result = notTotalDelete($pdo, $id);
        echo $result;
    }

?>