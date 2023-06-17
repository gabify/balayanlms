<?php

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
    }
?>
<?php require '../balayanlms/template/header.php';?>

    <?php if($book == 'deleted'):?>
        <?php include '../balayanlms/book/bookNotFound.php';?>
    <?php else:?>
        <div class="container-fluid d-flex justify-content-center my-4">
            <div class="border border-3 border-secondary rounded-4 my-5 p-4">
                <div class="row">
                    <div class="col col-6">
                        <img src="../balayanlms/assets/bookCover.jpg" alt="book cover" class="book-cover img-fluid img-thumbnail rounded-3">
                    </div>
                    <div class="col col-6 py-4">
                        <p>Accession Number: <?php echo htmlspecialchars($book['accessnum']);?></p>
                        <p>Call Number: <?php echo htmlspecialchars($book['callnum']);?></p>
                        <p>Title: <?php echo htmlspecialchars($book['title']);?></p>
                        <p>Author: <?php echo htmlspecialchars($book['author_name']);?></p>
                        <p>Publisher: <?php echo htmlspecialchars($book['publisher_name']);?></p>
                        <p>Copyright Year: <?php echo htmlspecialchars($book['copyright']);?></p>
                        <p>Copy: <?php echo htmlspecialchars($book['copy']);?></p>
                        <p>Status: <?php echo htmlspecialchars($book['stat_value']);?></p>
                        <div class="d-inline-block">
                            <a href="bookDashboard.php" class="btn btn-secondary" role="button">Back</a>
                            <a href="editBook.php?id=<?php echo htmlspecialchars($book['id']);?>" class="btn btn-warning">
                                Edit
                            </a>
                            <button class="btn btn-danger" onclick="deleteBookOnView(<?php echo htmlspecialchars($book['id']);?>)">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

<?php require '../balayanlms/template/footer.php';?>