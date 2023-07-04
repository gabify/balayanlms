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
            $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords 
            FROM books LEFT JOIN book_data
            ON book_data.id = books.book_Info_Id
            LEFT JOIN author
            ON author.id = book_data.author_id
            LEFT JOIN publisher
            ON publisher.id = book_data.publisher_id
            WHERE book_data.callnum LIKE '%$keyword%'
            OR book_data.title LIKE '%$keyword%'
            OR publisher.publisher_name LIKE '%$keyword%'
            OR author.author_name LIKE '%$keyword%'
            AND books.is_deleted = 0");
            $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPages = ceil($totalRecords['totalRecords']/$limit);
            $data['totalBooks'] = $totalRecords['totalRecords'];
            $data['totalPages'] = $totalPages;
            echo json_encode($data);
        }
    }
?>