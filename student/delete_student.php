<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $stmt = $pdo->prepare("DELETE FROM student WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'error';
        }
    }
?>