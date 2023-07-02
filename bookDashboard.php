<?php 
    if(!isset($_SESSION)){
        session_start();
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="container-fluid g-0">
        <?php include '../balayanlms/book/allBooks.php';?>
    </div>
<?php require '../balayanlms/template/footer.php';?>
        <script src="../balayanlms/book/deleteBook.js"></script>
        <script src="../balayanlms/book/dataTable.js"></script>
        <script src="../balayanlms/book/add_book.js"></script>
</body>
</html>