<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    $keyword = 'null';
    $numOfFaculties = 10;
    $offset = 0;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $keyword = '%'.$keyword.'%';
    }
    if(isset($_GET['limit'])){
        $numOfFaculties = htmlspecialchars($_GET['limit']);
    }
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
        $offset = ((int)$page - 1) * $numOfFaculties;
    }

    if($keyword == 'null'){
        $stmt = $pdo->prepare("SELECT faculty.id, faculty.employee_num, 
        user.first_name, user.last_name FROM faculty JOIN user 
        ON faculty.user_id = user.id LIMIT :opset, :page");
        $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':page', $numOfFaculties, PDO::PARAM_INT);
        $stmt->execute();
        $faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($faculty);
    }else{
        $keyword = '%'.$keyword.'%';
        $stmt = $pdo->prepare("SELECT faculty.id, faculty.employee_num, 
        user.first_name, user.last_name FROM faculty JOIN user 
        ON faculty.user_id = user.id 
        WHERE user.first_name LIKE :keyword 
        OR user.last_name LIKE :keyword
        LIMIT :opset, :page");
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':page', $numOfFaculties, PDO::PARAM_INT);
        $stmt->execute();
        $faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($faculty);
    }
?>