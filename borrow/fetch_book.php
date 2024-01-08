<?php

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $limit = 10;
    $offset = 0;
    $keyword = '%null%';

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $keyword = '%'.$keyword.'%';
    }
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
        $offset = ((int)$page - 1) * $limit;
    }
    
    $books = getAllBooks($pdo, $offset, $limit, $keyword);
    echo json_encode($books);
    
    //Get all books
    function getAllBooks($pdo, $offset, $limit, $keyword){
        if($keyword == '%null%'){
            $stmt = $pdo->prepare("SELECT books.id,
            books.title
            FROM books
            WHERE books.is_deleted = 0 
            AND books.status = 'Available'
            LIMIT :opset, :pages");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':pages', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($books){
                return $books;
            }else{
                return 'Some error occurred';
            }
        }else{
            $stmt = $pdo->prepare("SELECT books.id,
            books.title
            FROM books
            WHERE books.callnum LIKE :keyword
            OR books.title LIKE :keyword
            OR books.author LIKE :keyword
            OR books.publisher LIKE :keyword
            AND books.is_deleted = 0 
            AND books.status = 'Available'
            LIMIT :opset, :pages");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':pages', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if($books){
                return $books;
            }else{
                return 'Some error occurred';
            }
        }
    }
?>