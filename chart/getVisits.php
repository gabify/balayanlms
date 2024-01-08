<?php
     $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

     $day = (date("d") - date("w")) + 1;
     $month = date("m");
     $year = date("Y");
     $dayoftheWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
     $dataSet = array();


     function getVisits($pdo, $date){
        $stmt = $pdo->prepare("SELECT COUNT(*) AS visits FROM student_log WHERE date_in = :dateIn");
        $stmt->bindParam(':dateIn', $date, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['visits'];
     }

     for($i = 1; $i <= date("w"); $i++){
        $date = "$year-$month-$day";
        $dataSet[$dayoftheWeek[$i]] = getVisits($pdo, $date);
        $day++;
     }
     echo json_encode($dataSet);

?>