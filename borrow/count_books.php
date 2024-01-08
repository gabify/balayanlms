<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $keyword = 'null';
    $limit = 10;

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        if($keyword == 'null'){
            $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords FROM books WHERE is_deleted = 0 AND status = 'Available'");
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPages = ceil($totalRecords['totalRecords']/$limit);
            echo json_encode($totalPages);
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT COUNT(*) AS totalRecords 
            FROM books
            WHERE books.callnum LIKE :keyword
            OR books.title LIKE :keyword
            OR books.publisher LIKE :keyword
            OR books.author LIKE :keyword
            AND books.is_deleted = 0
            AND books.status = 'Available'");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPages = ceil($totalRecords['totalRecords']/$limit);
            echo json_encode($totalPages);
        }
    }
?>