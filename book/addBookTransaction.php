// dunno, ayaw maginsert
<?php
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    date_default_timezone_set("Asia/Manila");
    $bookData = file_get_contents('php://input');
    $bookData = json_decode($bookData, true);
    $copy = 1;
    $status = 'Available';
    $now = date("Y-m-d H:i:s");
    $stmt = $pdo->prepare("INSERT INTO books(callnum,
    author, title, publisher, copyright, copy, status, created_at) 
    VALUES(:callNum, :authorName, :bookTitle, :publisherName, :copyrightYear, :copyNum, :statusVal, :createdAt)");
    $stmt->bindParam(':callNum', $bookData['callnum'], PDO::PARAM_STR);
    $stmt->bindParam(':authorName', $bookData['author'], PDO::PARAM_STR);
    $stmt->bindParam(':bookTitle', $bookData['title'], PDO::PARAM_STR);
    $stmt->bindParam(':publisherName', $bookData['publisher'], PDO::PARAM_STR);
    $stmt->bindParam(':copyrightYear', $bookData['copyright'], PDO::PARAM_INT);
    $stmt->bindParam(':copyNum', $copy, PDO::PARAM_INT);
    $stmt->bindParam(':statusVal', $status, PDO::PARAM_STR);
    $stmt->bindParam(':createdAt', $now, PDO::PARAM_STR);

    if($stmt->execute()){
        echo 'success';
    }else{
        echo 'Aborted';
    }
?>