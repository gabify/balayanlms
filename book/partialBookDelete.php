<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../book/bookHandler.php';

    $data = file_get_contents("php://input");
    $id = json_decode($data, true);

    $result = notTotalDelete($pdo, $id['id']);

    return $result;
?>