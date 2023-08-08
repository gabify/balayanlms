<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $keyword = 'null';
    $numOfThesis = 10;
    $offset = 0;
    $page = 1;

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['limit'])){
        $numOfThesis = htmlspecialchars($_GET['limit']);
        $numOfThesis = intval($numOfThesis);
    }
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
        $pageVal = intval($page) - 1;
        $offset = $pageVal * $numOfThesis;
    }

    function fetchThesis($pdo, $keyword, $numOfThesis, $offset){
        if($keyword == 'null'){
            $stmt = $pdo->prepare("SELECT id, callnum, title, publication_year FROM thesis 
            LIMIT :opset, :page");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':page', $numOfThesis, PDO::PARAM_INT);
            $stmt->execute();
            $thesis = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $thesis;
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT id, callnum, title, publication_year FROM thesis 
            WHERE callnum LIKE :keyword 
            OR title LIKE :keyword 
            OR adviser LIKE :keyword 
            OR author LIKE :keyword
            LIMIT :opset, :page");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':page', $numOfThesis, PDO::PARAM_INT);
            $stmt->execute();
            $thesis = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $thesis;
        }
    }

    echo json_encode(fetchThesis($pdo, $keyword, $numOfThesis, $offset));
?>