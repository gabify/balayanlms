<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    function getDataByStat($pdo, $status){
        $stmt = $pdo->prepare("SELECT COUNT(id) AS allBooks FROM books 
        WHERE status = :stat");
        $stmt->bindParam(':stat', $status, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['allBooks'];
    }


    if(isset($_GET['status'])){
        $status = htmlspecialchars($_GET['status']);
        echo getDataByStat($pdo, $status);
    }


?>