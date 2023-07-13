<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    //fettch data from db
    function fetchStudent($pdo){
        $stmt = $pdo->query('CALL getAllStudents()');
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($students){
            return $students;
        }else{
            return 'An error occured. Retrieved empty dataset';
        }
    }

    $students = fetchStudent($pdo);
    echo json_encode($students);
?>