<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    $keyword = 'null';
    $numOfThesis = 10;
    $data = array('totalThesis'=>"", 'totalPage'=>"");

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['limit'])){
        $numOfThesis = htmlspecialchars($_GET['limit']);
        $numOfThesis = (int)$numOfThesis;
    }
    echo $numOfThesis;

    /* if($keyword == 'null'){
        $stmt = $pdo->query('SELECT COUNT(*) AS total FROM thesis');
        $stmt->execute();
        $totalThesis = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalThesis'] = $totalThesis['total'];
        $data['totalPage'] = ceil($totalThesis['total']/$numOfThesis);
        echo json_encode($data);
    }else{
        $keyword = '%'.$keyword.'%';
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM thesis 
        WHERE callnum LIKE :keyword 
        OR title LIKE :keyword 
        OR author LIKE :keyword 
        OR adviser LIKE :keyword');
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        $totalThesis = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalThesis'] = $totalThesis['total'];
        $data['totalPage'] = ceil($totalThesis['total']/$numOfThesis);
        echo json_encode($data);
    } */

?>