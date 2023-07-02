<?php 
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
        $stats = getStatus($pdo);
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
                    <form id="updateForm">
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Call Number</span>
                            <input 
                                type="text" 
                                id="callnum" 
                                class="form-control" 
                                placeholder="Call Number" 
                                aria-label="Call Number" 
                                aria-describedby="basic-addon1" 
                                required
                                value="<?php echo htmlspecialchars($book['callnum']);?>">
                            <div class="invalid-feedback">
                                Please provide a <b>call number</b>.
                            </div>
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Title</span>
                            <input 
                                type="text" 
                                id="title" 
                                class="form-control" 
                                placeholder="Title" 
                                aria-label="Title" 
                                aria-describedby="basic-addon1" 
                                required
                                value="<?php echo htmlspecialchars($book['title']);?>">
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Publisher</span>
                            <input 
                                type="text"
                                id="publisher" 
                                class="form-control" 
                                placeholder="Publisher" 
                                aria-label="Publisher" 
                                aria-describedby="basic-addon1" 
                                required
                                value="<?php echo htmlspecialchars($book['publisher_name']);?>">
                            <div class="invalid-feedback">
                                Please provide a <b>title</b>.
                            </div>
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Author</span>
                            <input 
                                type="text" 
                                id="author" 
                                class="form-control" 
                                placeholder="Author" 
                                aria-label="Author" 
                                aria-describedby="basic-addon1" 
                                required
                                value="<?php echo htmlspecialchars($book['author_name']);?>">
                            <div class="invalid-feedback">
                                Please provide an <b>author</b>.
                            </div>
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Copyright Year</span>
                            <input 
                                type="text" 
                                id="copyright" 
                                class="form-control" 
                                placeholder="199x" 
                                aria-label="copyright" 
                                aria-describedby="basic-addon1" 
                                required
                                value="<?php echo htmlspecialchars($book['copyright']);?>">
                            <div class="invalid-feedback">
                                Please provide a <b>copyright year</b>.
                            </div>
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text" id="basic-addon1">Status</span>
                            <select name="status" id="status" class="form-select">
                                <?php foreach($stats as $stat):?>
                                    <option
                                        <?php if($book['stat_value'] == $stat['stat_value']):?>
                                        selected
                                        <?php endif;?>
                                        value="<?php echo htmlspecialchars($stat['id']);?>">
                                        <?php echo htmlspecialchars($stat['stat_value']);?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a <b>Status</b>.
                            </div>
                        </div>
                        <input type="hidden" name="bookId" id="bookId" value="<?php echo htmlspecialchars($book['id']);?>">
                        <button type="submit" id="update" class="btn btn-outline-secondary btn-lg d-inline me-2">Update</button>
                        <a href="bookDashboard.php" class="text-decoration-none "> Go Back</a>
                    </form>
                </div>
            </div>
        <?php else:?>
            <?php include '../balayanlms/book/bookNotFound.php';?>    
        <?php endif;?>
    </main>
<?php require '../balayanlms/template/footer.php';?>
<script src="../balayanlms/book/updateBook.js"></script>
</body>
</html>