<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    
    $keyword = 'null';
    $numOfFaculties = 10;
    $data = array('totalFaculty'=>"", 'totalPage'=>"");

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['limit'])){
        $numOfFaculties = htmlspecialchars($_GET['limit']);
    }

    if($keyword == 'null'){
        $stmt = $pdo->query("SELECT COUNT(*) AS total FROM faculty");
        $stmt->execute();
        $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalFaculty'] = $faculty['total'];
        $data['totalPage'] = ceil($faculty['total']/ $numOfFaculties);
        echo json_encode($data);
    }else{
        $keyword = '%'.$keyword.'%';
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM faculty 
        JOIN user ON faculty.user_id = user.id 
        WHERE user.first_name LIKE :keyword 
        OR user.last_name LIKE :keyword");
        $stmt->execute();
        $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalFaculty'] = $faculty['total'];
        $data['totalPage'] = ceil($faculty['total']/ $numOfFaculties);
        echo json_encode($data);
    }
?>