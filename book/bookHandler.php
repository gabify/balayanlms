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

    function insertBookDetails($pdo, $bookInfo): int
    {
        $sql = 'CALL insertBookInfo(:accessnumber, :callnumber, :bookTitle, :bookAuthor, :bookPublisher, :bookCopyright)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accessnumber', $bookInfo['accessnum'], PDO::PARAM_INT);
        $stmt->bindParam(':callnumber', $bookInfo['callnum'], PDO::PARAM_STR);
        $stmt->bindParam(':bookTitle', $bookInfo['title'], PDO::PARAM_STR);
        $stmt->bindParam(':bookAuthor', $bookInfo['author'], PDO::PARAM_INT);
        $stmt->bindParam(':bookPublisher', $bookInfo['publisher'], PDO::PARAM_INT);
        $stmt->bindParam(':bookCopyright', $bookInfo['copyright'], PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();

    }

    function insertBook($pdo, $bookInfoId): int
    {
        $sql = 'CALL insertBook(:InfoId, :statusId)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':InfoId', $bookInfoId, PDO::PARAM_INT);
        $stmt->bindParam(':statusId', 1, PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    //book transaction
    function newBookTransact($pdo, $bookInfo)
    {
        try{
            $pdo->beginTransaction();

            $bookInfoId = insertBookDetails($pdo, $bookInfo);

            if(!$bookInfoId){
                $pdo->rollBack();
                return 'Aborted';
            }

            insertBook($pdo, $bookInfoId);
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();

            return $e->getMessage();
        }
        
        return 'success';
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

    function getAllPublishers($pdo){
        $sql = 'CALL getAllPublishers()';
        $stmt = $pdo->query($sql);
        $publishers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $publishers;
    }

    function getAllAuthors($pdo){
        $sql = 'CALL getAllAuthors()';
        $stmt = $pdo->query($sql);
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $authors;
    }

?>