<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    $studentData = json_decode(file_get_contents('php://input'),true);

    //insert student on user table
    function insertUser($pdo, $lastname, $firstname, $usertype){
        $stmt = $pdo->prepare("INSERT INTO user(first_name, last_name, user_type)
        VALUES(:firstname, :lastname, :usertype)");
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':usertype', $usertype, PDO::PARAM_STR);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    //insert student on student table
    function insertStudent($pdo, $srcode, $program, $uid){
        $stmt = $pdo->prepare("INSERT INTO student(srcode, program, user_id)
        VALUES(:srcode, :program, :userid)");
        $stmt->bindParam(':srcode', $srcode, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->bindParam(':userid', $uid, PDO::PARAM_INT);
        $stmt->execute();
    }

    //creating student transaction
    function createStudent($pdo, $student){
        try{
            $pdo->beginTransaction();
            $uid = insertUser($pdo, $student['lastname'], $student['firstname'], "student");
            if(!$uid){
                $pdo->rollBack();
                return "An error occured during operation.";
            }
            echo insertStudent($pdo, $student['srcode'], $student['program'], $uid);
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();
            return $e->getMessage();
        }
        return 'success';
    }

    echo createStudent($pdo, $studentData);
?>