<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    //fettch data from db
    function fetchStudent($pdo, $keyword, $numOfstudents, $page){
        $stmt = $pdo->prepare('CALL getAllStudents(:keyword, :opset, :page)');
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->bindParam(':opset', $page, PDO::PARAM_INT);
        $stmt->bindParam(':page', $numOfstudents, PDO::PARAM_INT);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($students){
            return $students;
        }else{
            return 'An error occured. Retrieved empty dataset';
        }
    }

    $keyword = '%null%';
    $numOfstudents = 10;
    $page = 0;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $keyword = '%'.$keyword.'%';
    }
    if(isset($_GET['limit'])){
        $numOfstudents = htmlspecialchars($_GET['limit']);
    }

    $students = fetchStudent($pdo, $keyword, $numOfstudents, $page);
    echo json_encode($students);
?>