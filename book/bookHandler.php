<?php 

    //Insert Author
    function insertAuthor($pdo, $author)
    {
        $sql = 'CALL insertAuthor(:author)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Insert Publisher
    function insertPublisher($pdo, $publisher){
        $sql = 'CALL insertPublisher(:publisher)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Get all books
    function getAllBooks($pdo){
        $sql = 'CALL getAllBooks';
        $stmt = $pdo->query($sql);
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($books){
            return $books;
        }else{
            return 'Some error occurred';
        }
    }

?>