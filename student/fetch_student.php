<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    //fettch data from db
    function fetchStudent($pdo, $keyword, $numOfstudents, $offset){
        if($keyword == '%null%'){
            $stmt = $pdo->prepare("SELECT student.id,
            student.srcode,
            user.last_name,
            user.first_name,
            student.program,
            student.course
            FROM student LEFT JOIN user
            ON user.id = student.user_id
            LIMIT :opset, :page");
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':page', $numOfstudents, PDO::PARAM_INT);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($students){
                return $students;
            }else{
                return 'An error occured. Retrieved empty dataset';
            }
        }else{
            $stmt = $pdo->prepare("SELECT student.id,
            student.srcode,
            user.last_name,
            user.first_name,
            student.program,
            student.course
            FROM student LEFT JOIN user
            ON user.id = student.user_id
            WHERE student.srcode LIKE :keyword 
            OR user.last_name LIKE :keyword
            OR user.first_name LIKE :keyword
            OR student.program LIKE :keyword 
            OR student.course LIKE :keyword
            LIMIT :opset, :page");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->bindParam(':opset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':page', $numOfstudents, PDO::PARAM_INT);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($students){
                return $students;
            }else{
                return 'An error occured. Retrieved empty dataset';
            }
        }
    }

    $keyword = '%null%';
    $numOfstudents = 10;
    $offset = 0;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $keyword = '%'.$keyword.'%';
    }
    if(isset($_GET['limit'])){
        $numOfstudents = htmlspecialchars($_GET['limit']);
    }
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
        $offset = ((int)$page - 1) * $numOfstudents;
    }

    $students = fetchStudent($pdo, $keyword, $numOfstudents, $offset);
    echo json_encode($students);
?>