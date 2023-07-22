<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    //fettch data from db
    function fetchStudent($pdo, $keyword){
        $stmt = $pdo->prepare('CALL getAllStudents(:keyword)');
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($students){
            return $students;
        }else{
            return 'An error occured. Retrieved empty dataset';
        }
    }

    $keyword = '%null%';
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $keyword = '%'.$keyword.'%';
    }

    $students = fetchStudent($pdo, $keyword);
    echo json_encode($students);
?>