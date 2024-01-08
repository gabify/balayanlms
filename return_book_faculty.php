<?php

    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    date_default_timezone_set('Asia/Manila');
    $id = '';
    $transact = '';
    $bookId = '';
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_GET['book-transact'])){
        $transact = htmlspecialchars($_GET['book-transact']);
    }
    if(isset($_GET['book-id'])){
        $bookId = htmlspecialchars($_GET['book-id']);
    }
    


    function returnBook($pdo, $transact){
        $dateReturned = date('y-m-d');
        $returned = 1;
        $stmt = $pdo->prepare("UPDATE book_borrow SET is_returned=:returned, date_returned=:dateReturned
        WHERE id=:id");
        $stmt->bindParam(':returned', $returned, PDO::PARAM_INT);
        $stmt->bindParam(':dateReturned', $dateReturned, PDO::PARAM_STR);
        $stmt->bindParam(':id', $transact, PDO::PARAM_INT);
        $stmt->execute();
    }

    function updateBookStat($pdo, $bookId){
        $bookId = intval($bookId);
        $stat= 'Available';
        $stmt = $pdo->prepare("UPDATE books SET status=:status WHERE id=:id");
        $stmt->bindParam(':status', $stat, PDO::PARAM_STR);
        $stmt->bindParam(':id', $bookId, PDO::PARAM_INT);
        $stmt->execute();
    }

    function updateFacultyBorrow($pdo, $facultyId){
        $facultyId = intval($facultyId);
        $stmt = $pdo->prepare("UPDATE faculty SET borrowed_books=borrowed_books-1 WHERE id=:id");
        $stmt->bindParam(':id', $facultyId, PDO::PARAM_INT);
        $stmt->execute();
    }


    function returnTransaction($pdo, $id, $transact, $bookId){
        try{
            $pdo->beginTransaction();
            returnBook($pdo, $transact);
            updateBookStat($pdo,$bookId);
            updateFacultyBorrow($pdo, $id);
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();
            return die($e->getMessage());
        }
        return true;
    }
    $result = returnTransaction($pdo, $id, $transact, $bookId);
    if($result){
        $_SESSION['status'] = 'success';
        $_SESSION['statusIcon'] = 'success';
        $_SESSION['statusTitle'] = 'Operation successful';
        $_SESSION['statusText'] = 'The book has been returned successfully.';
        header('Location:view_faculty.php?id='.$id);
    }else{
        $_SESSION['status'] = 'error';
        $_SESSION['statusIcon'] = 'error';
        $_SESSION['statusTitle'] = 'Operation failed';
        $_SESSION['statusText'] = $result;
        header('Location:view_faculty.php?id='.$id);
    }
?>