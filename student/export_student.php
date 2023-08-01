<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    $date = '';
    if(isset($_GET['log'])){
        $date = htmlspecialchars($_GET['log']);
    }

    function getLog($pdo, $date){
        $stmt = $pdo->prepare("SELECT student_log.date_in,
        student.srcode,
        user.last_name,
        user.first_name,
        student.program,
        student_log.time_in,
        student_log.time_out
        FROM student_log JOIN student
        ON student_log.student_id = student.id
        JOIN user ON user.id = student.user_id
        WHERE date_in = :logDate");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $logs;
    }

    function filterData(&$str){
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"'. str_replace('"', '""', $str) .'"';
    }

    function convertToExcel($logs, $logDate){
        //excel file name
        $filename = "student-log-".$logDate.".xls";
        
        $headers = array('Date', 'Srcode', 'Last Name', 'First Name', 'Program', 'Time In', 'Time Out');
        $excelData = implode("\t", array_values($headers)) . "\n";
        foreach($logs as $log){
            array_walk($log, 'filterData');
            $excelData .= implode("\t", array_values($log)) . "\n"; 
        }
        //headers for download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo $excelData;
        exit;
    }
    $log = getLog($pdo, $date);
    convertToExcel($log, $date);
?>