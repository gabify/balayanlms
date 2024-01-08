<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    $userType = '';
    $keyword = '';
    $page_num = 1;
    $total_record_per_page = 10;

    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
    }
    if(isset($_SESSION['user_type'])){
        $userType = $_SESSION['user_type'];
    }

    function getTotalPages($pdo, $total_record_per_page, $keyword){
        if($keyword == ''){
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM books WHERE is_deleted = 0 AND status = 'Available'");
            $stmt->execute();
            $totalBooks = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalBooks = $totalBooks['total'];
            return ceil($totalBooks/$total_record_per_page);
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM books 
            WHERE callnum LIKE :keyword OR
            title LIKE :keyword OR
            author LIKE :keyword AND
            is_deleted = 0 AND status = 'Available'");
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            $totalBooks = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalBooks = $totalBooks['total'];
            return ceil($totalBooks/$total_record_per_page);
        }
    }

    function getBooks($pdo, $offset, $total_record_per_page, $keyword){
        if($keyword == ''){
            $stmt = $pdo->prepare("SELECT books.id,
            books.callnum,
            books.title,
            books.copyright FROM books WHERE is_deleted = 0 AND status = 'Available' 
            LIMIT :offset, :total_record_per_page");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':total_record_per_page', $total_record_per_page, PDO::PARAM_INT);
        }else{
            $keyword = '%'.$keyword.'%';
            $stmt = $pdo->prepare("SELECT books.id,
            books.callnum,
            books.title,
            books.copyright FROM books WHERE 
            (is_deleted = 0 AND status = 'Available') AND
            (callnum LIKE :keyword OR
            title LIKE :keyword OR
            author LIKE :keyword) 
            LIMIT :offset, :total_record_per_page");
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':total_record_per_page', $total_record_per_page, PDO::PARAM_INT);
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        }
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $_SESSION['id'] = $id;
    }
    if(isset($_GET['user_type'])){
        $userType = htmlspecialchars($_GET['user_type']);
        $_SESSION['user_type'] = $userType;
    }
    if(isset($_GET['page-num'])){
        $page_num = htmlspecialchars($_GET['page-num']);
    }
    $offset = (intval($page_num) - 1) * $total_record_per_page;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
        $books = getBooks($pdo, $offset, $total_record_per_page, $keyword);
        $totalPage = getTotalPages($pdo, $total_record_per_page, $keyword);
        
    }

    $next = intval($page_num) + 1;
    $prev = intval($page_num) - 1;
    $adjacents = 2;
    $totalPage = getTotalPages($pdo, $total_record_per_page, $keyword);
    $secondLast = $totalPage - 1;
    $books = getBooks($pdo, $page_num, $total_record_per_page, $keyword);

?>
<?php require '../balayanlms/template/header.php';?>
    <main class="w-75 mx-auto my-4">
        <section class="card mb-1 px-4 py-3">
            <div class="d-flex justify-content-between">
                <h3 class="fs-2 fw-light">Book Borrowing</h3>
                <a href="javascript:history.go(-1)" class="btn btn-danger pt-2">Back</a>
            </div>
        </section>
        <?php if($userType == 'student'):?>
            <?php include '../balayanlms/studentBorrow.php';?>
        <?php elseif($userType == 'faculty'):?>
            <?php include '../balayanlms/facultyBorrow.php';?>
        <?php endif?>
    </main>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>
