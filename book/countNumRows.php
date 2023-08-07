<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $keyword = 'null';
    $limit = 10;
    $data = array('totalBooks'=>"",'totalPages'=>"");
    if(isset($_GET['limit'])){
        $limit = htmlspecialchars($_GET['limit']);
    }
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        if($keyword == 'null'){
            $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords FROM books WHERE is_deleted = 0");
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPages = ceil($totalRecords['totalRecords']/$limit);
            $data['totalBooks'] = $totalRecords['totalRecords'];
            $data['totalPages'] = $totalPages;
            echo json_encode($data);
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT COUNT(*) AS totalRecords 
            FROM books
            WHERE books.callnum LIKE :keyword
            OR books.title LIKE :keyword
            OR books.publisher LIKE :keyword
            OR books.author LIKE :keyword
            AND books.is_deleted = 0");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPages = ceil($totalRecords['totalRecords']/$limit);
            $data['totalBooks'] = $totalRecords['totalRecords'];
            $data['totalPages'] = $totalPages;
            echo json_encode($data);
        }
    }
?>