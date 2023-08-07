<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    
    $keyword = 'null';
    $numOfStudents = 10;
    $data = array('totalStudents'=>"", 'totalPage'=>"");

    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['limit'])){
        $numOfStudents = htmlspecialchars($_GET['limit']);
    }

    if($keyword == 'null'){
        $stmt = $pdo->query("SELECT COUNT(*) AS totalStudents
        FROM student");
        $stmt->execute();
        $students = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalPage'] = ceil($students['totalStudents']/$numOfStudents);
        $data['totalStudents'] = $students['totalStudents'];
        echo json_encode($data);
    }else{
        $stmt = $pdo->query("SELECT COUNT(*) AS totalStudents
        FROM student LEFT JOIN user
        ON student.user_id = user.id
        WHERE user.first_name LIKE '%$keyword%'
        OR user.last_name LIKE '%$keyword%'
        OR student.srcode LIKE '%$keyword%'
        OR student.program LIKE '%$keyword%'");
        $stmt->execute();
        $students = $stmt->fetch(PDO::FETCH_ASSOC);
        $data['totalPage'] = ceil($students['totalStudents']/$numOfStudents);
        $data['totalStudents'] = $students['totalStudents'];
        echo json_encode($data);
    }

?>