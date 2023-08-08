<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    date_default_timezone_set('Asia/Manila');
    $now = date("Y-m-d H:i:s");
    $copy = 1;

    $thesis = json_decode(file_get_contents('php://input'),true);

    $stmt= $pdo->prepare("INSERT INTO thesis(callnum, title, author, adviser, publication_year, copy,
    created_at) VALUES(:callnum, :title, :author, :adviser, :publicationYear, :copy, :createdAt)");
    $stmt->bindParam(':callnum', $thesis['callnum'], PDO::PARAM_STR);
    $stmt->bindParam(':title', $thesis['title'], PDO::PARAM_STR);
    $stmt->bindParam(':author', $thesis['author'], PDO::PARAM_STR);
    $stmt->bindParam(':adviser', $thesis['adviser'], PDO::PARAM_STR);
    $stmt->bindParam(':publicationYear', $thesis['publicationYear'], PDO::PARAM_STR);
    $stmt->bindParam(':copy', $copy, PDO::PARAM_STR);
    $stmt->bindParam(':createdAt', $now, PDO::PARAM_STR);
    if($stmt->execute()){
        echo 'success';
    }else{
        echo 'failed';
    }
?>