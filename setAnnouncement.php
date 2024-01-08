<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    date_default_timezone_set('Asia/Manila');
    session_start();
    
    if(isset($_POST['save'])){
        $title = htmlspecialchars($_POST['title']);
        $body = htmlspecialchars($_POST['body']);
        $now = date('Y-m-d h:i:s a', time());

        $stmt = $pdo->prepare("UPDATE announcement SET title=:title, body=:body, updated_at= :now WHERE id= 1");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':now', $now, PDO::PARAM_STR);
        if($stmt->execute()){
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'A new announcement has been published.';
            header('Location:index.php');
        }else{
            $_SESSION['status'] = 'errror';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Operation failed';
            $_SESSION['statusText'] = 'An error occured during operation. Please try again later.';
            header('Location:index.php');
        }
    }

?>