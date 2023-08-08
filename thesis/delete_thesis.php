<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $stmt = $pdo->prepare("UPDATE thesis SET is_deleted = 1 WHERE id =:id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'failed';
        }
    }
?>