<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $stmt = $pdo->prepare("UPDATE books SET is_deleted = 1 WHERE id = :id");
        $stmt->bindparam(':id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'An error occured';
        }
    }

?>