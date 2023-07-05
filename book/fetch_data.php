<?php
    //may mali sa coputation ng offset
    //konti na lang
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $limit = 10;
    $offset = 0;
    $keyword = '%null%';

    if(isset($_GET['limit'])){
        $limit = htmlspecialchars($_GET['limit']);
    }

    if(isset($_GET['offset'])){
        $offset = htmlspecialchars($_GET['offset']);
    }

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
        $stmt = $pdo->prepare('CALL getAllBooks(:opset, :pages, :keyword)');
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
?>