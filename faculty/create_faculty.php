<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    $facultyData = json_decode(file_get_contents('php://input'),true);

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

    function insertFaculty($pdo, $employeeNum, $userId){
        $stmt = $pdo->prepare("INSERT INTO faculty(employee_num, user_id)
        VALUES(:employeeNum, :userId)");
        $stmt->bindParam(':employeeNum', $employeeNum, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    function addNewFaculty($pdo, $facultyData){
        try{
            $pdo->beginTransaction();
            $uid = insertUser($pdo, $facultyData['lastname'], $facultyData['firstname'], 'faculty');
            if(!$uid){
                $pdo->rollBack();
                return "An error occured during operation";
            }
            if(insertFaculty($pdo, $facultyData['employeeNum'], $uid)){
                $pdo->commit();
                return 'success';
            }else{
                $pdo->rollBack();
                return 'An error occured during operatiom. Try again later';
            }
        }catch(\PDOException $e){
            $pdo->rollBack();
            return $e->getMessage();
        }
    }

    echo addNewFaculty($pdo, $facultyData);
?>