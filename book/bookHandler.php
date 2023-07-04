<?php 

    //Insert Author
    function getAuthorId($pdo, $author)
    {   
        $sql = 'CALL getAuthor(:authorName)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':authorName', $author, PDO::PARAM_STR);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        return $author['authorId'];
    }

    //Insert Publisher
    function getPublisherId($pdo, $publisher){
        $sql = 'CALL getPublisher(:publisherName)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':publisherName', $publisher, PDO::PARAM_STR);
        $stmt->execute();

        $publisher = $stmt->fetch(PDO::FETCH_ASSOC);

        return $publisher['publisherId'];
    }

    function insertBookDetails($pdo, $bookInfo, $authorId, $publisherId): int
    {
        $sql = 'CALL insertBookDetails(:callnumber, :bookTitle, :bookAuthor, :bookPublisher, :bookCopyright)';
        $stmt = $pdo->prepare($sql);
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
        $now = date("Y-m-d H:i:s");
        $stmt = $pdo->prepare('CALL insertBook(:InfoId, :statusId, :createdAt)');
        $stmt->bindParam(':InfoId', $bookInfoId, PDO::PARAM_INT);
        $stmt->bindParam(':statusId', $statusId, PDO::PARAM_INT);
        $stmt->bindParam(':createdAt', $now, PDO::PARAM_STR); //Timestamp not inserting

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

    //Get one book
    function getBook($pdo, $id){
        $stmt = $pdo->prepare('CALL getBook(:id)');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book;
    }

    //get status
    function getStatus($pdo){
        $stmt = $pdo->query('CALL getStatus()');
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stats;
    }

    //Get total number of pages in pagination
    //Still ongoing need to do it faster
    function getTotalSearchedPages($pdo, $total_records_per_page, $keyword){
        $stmt = $pdo->query("SELECT COUNT(*) AS totalRecords FROM books WHERE is_deleted = 0");
        $totalRecords = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalPages = ceil($totalRecords['totalRecords']/$total_records_per_page);
        return $totalPages;
    }

    //Update Book
    function updateBookDetails($pdo, $bookInfo, $authorId, $publisherId){
        $stmt = $pdo->prepare('CALL updateBookDetails(:callnumber, :bookTitle, :bookAuthor, :bookPublisher, :bookCopyright, :stat, :id)');
        $stmt->bindParam(':callnumber', $bookInfo['callnum'], PDO::PARAM_STR);
        $stmt->bindParam(':bookTitle', $bookInfo['title'], PDO::PARAM_STR);
        $stmt->bindParam(':bookAuthor', $authorId, PDO::PARAM_INT);
        $stmt->bindParam(':bookPublisher', $publisherId, PDO::PARAM_INT);
        $stmt->bindParam(':bookCopyright', $bookInfo['copyright'], PDO::PARAM_INT);
        $stmt->bindParam(':stat', $bookInfo['status'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $bookInfo['id'], PDO::PARAM_INT);

        if($stmt->execute()){
            return 'success';
        }else{
            return 'failed';
        }
        
    }
    //update transaction
    function updateBookTransact($pdo, $bookInfo)
    {
        try{
            $pdo->beginTransaction();

            $authorId = getAuthorId($pdo, $bookInfo['author']);
            $publisherId = getPublisherId($pdo, $bookInfo['publisher']);

            $result = updateBookDetails($pdo, $bookInfo, $authorId, $publisherId);

            if($result == 'failed'){
                $pdo->rollBack();
                return 'failed';
            }
            $pdo->commit();
        }catch(\PDOException $e){
            $pdo->rollBack();
            return $e->getMessage();
        }
        
        return $result;
    }

    //Not totally delete a book
    function notTotalDelete($pdo, $id){
        $stmt = $pdo->prepare('CALL notTotalDelete(:id)');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['result'];
    }   

?>