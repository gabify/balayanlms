<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <main class="container-fluid px-5 py-5">
        <?php if($book):?>
            <div class="row mx-5 px-5 g-0 d-flex justify-content-center">
                <div class="col-6">
                    <img src="../balayanlms/assets/bookCover.jpg" alt="book cover" class="img-fluid rounded book-cover">
                </div>
                <div class="col-6 pt-4">
                    <h4 class="display-4 mt-3 mb-0"><?php echo htmlspecialchars($book['title']);?></h4>
                    <div class="lead text-secondary mt-0">
                        <p 
                            class="d-inline"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-title="Accession Number">
                            <?php echo htmlspecialchars($book['accessnum']);?>
                        </p>
                        <p class="d-inline">|</p>
                        <p class="d-inline"
                            data-bs-toggle="tooltip"
                            data-bs-placement="bottom"
                            data-bs-title="Call Number">
                            <?php echo htmlspecialchars($book['callnum']);?>
                        </p>
                    </div>
                    <div class="mt-5 my-5">
                        <div class="mt-1">
                            <p class="fw-light fs-4 d-inline">Author:</p>
                            <p class="fw-normal fs-4 d-inline"><?php echo htmlspecialchars($book['author_name']);?></p>
                        </div>
                        <div class="mt-1">
                            <p class="fw-light fs-4 d-inline">Publisher:</p>
                            <p class="fw-normal fs-4 d-inline"><?php echo htmlspecialchars($book['publisher_name']);?></p>
                        </div>
                        <div class="mt-1">
                            <p class="fw-light fs-4 d-inline">Copyright Year:</p>
                            <p class="fw-normal fs-4 d-inline"><?php echo htmlspecialchars($book['copyright']);?></p>
                        </div>
                    </div>
                    <p class="fw-semibold fs-2 d-inline"><?php echo htmlspecialchars($book['stat_value']);?></p>
                    <div class="my-5">
                        <a 
                            href="borrow.php?id=<?php echo htmlspecialchars($book['id']);?>" 
                            class="btn btn-outline-secondary btn-lg d-inline mx-2 
                            <?php if($book['stat_value'] != 'Available')echo 'disabled'?>">
                            Borrow
                        </a>
                        <a href="editBook.php?id=<?php echo htmlspecialchars($book['id']);?>" class="btn btn-outline-secondary btn-lg d-inline mx-2">Edit</a>
                        <button type="button" onclick="deleteBookOnView(<?php echo htmlspecialchars($book['id']);?>)" class="btn btn-outline-secondary btn-lg d-inline mx-2">Delete</button>
                    </div>
                    <a href="bookDashboard.php" class="text-decoration-none "> Go Back</a>
                </div>
            </div>
        <?php else:?>
            <?php include '../balayanlms/book/bookNotFound.php';?>    
        <?php endif;?>
    </main>
    <?php require '../balayanlms/template/footer.php';?>
    <script src="../balayanlms/book/deleteBook.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    </body>
</html>