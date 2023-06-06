<?php 

    //Insert Author
    function getAuthorId($pdo, $author)
    {
        $sql = 'CALL getAuthor(:author)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        return $author['authorId'];
    }

    //Insert Publisher
    function getPublisherId($pdo, $publisher){
        $sql = 'CALL getPublisher(:publisher)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':publisher', $publisher, PDO::PARAM_STR);
        $stmt->execute();

        $publisher = $stmt->fetch(PDO::FETCH_ASSOC);

        return $publisher['publisherId'];
    }

    function insertBookDetails($pdo, $bookInfo, $authorId, $publisherId): int
    {
        $sql = 'CALL insertBookInfo(:accessnumber, :callnumber, :bookTitle, :bookAuthor, :bookPublisher, :bookCopyright)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':accessnumber', $bookInfo['accessnum'], PDO::PARAM_INT);
        $stmt->bindParam(':callnumber', $bookInfo['callnum'], PDO::PARAM_STR);
        $stmt->bindParam(':bookTitle', $bookInfo['title'], PDO::PARAM_STR);
        $stmt->bindParam(':bookAuthor', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':bookPublisher', $publisherId, PDO::PARAM_INT);
        $stmt->bindParam(':bookCopyright', $bookInfo['copyright'], PDO::PARAM_INT);

        $stmt->execute();

        $bookInfoId = $stmt->fetch(PDO::FETCH_ASSOC);

        return $bookInfoId['bookInfoId'];

    }

    function insertBook($pdo, $bookInfoId, $statusId): int
    {
        $sql = 'CALL insertBook(:InfoId, :statusId)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':InfoId', $bookInfoId, PDO::PARAM_INT);
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();
    }

    //book transaction
    function newBookTransact($pdo, $bookInfo)
    {
        try{
            $pdo->beginTransaction();

            $authorId = getAuthorId($pdo, $bookInfo['author']);
            $publisherId = getPublisherId($pdo, $bookInfo['publisher']);

            $bookInfoId = insertBookDetails($pdo, $bookInfo, $authorId, $publisherId);

            if(!$bookInfoId){
                $pdo->rollBack();
                return 'Aborted';
            }

            insertBook($pdo, $bookInfoId, 1);
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

?>