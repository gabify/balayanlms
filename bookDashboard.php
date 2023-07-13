<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    $page = 1;
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="container-fluid g-0">
        <?php include '../balayanlms/book/allBooks.php';?>
    </div>
    <input type="hidden" name="page" id="page" value="<?php echo htmlspecialchars($page);?>">
<?php require '../balayanlms/template/footer.php';?>
        <script src="../balayanlms/book/deleteBook.js"></script>
        <script src="../balayanlms/book/dataTable.js"></script>
        <script src="../balayanlms/book/dataList.js"></script>
        <script src="../balayanlms/book/add_book.js"></script>
</body>
</html>