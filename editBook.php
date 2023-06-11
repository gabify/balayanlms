<?php
    session_start();
    $pdo = require '../balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';
    $book = '';

    $bookInfo = ['id' => '', 'accessnum'=>'','callnum'=>'','title'=>'','publisher'=>'','author'=>'','copyright'=>'', 'status'=>''];

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
        $stats = getStatus($pdo);

        $bookInfo['id'] = htmlspecialchars($book['id']);
        $bookInfo['accessnum'] = htmlspecialchars($book['accessnum']);
        $bookInfo['callnum'] = htmlspecialchars($book['callnum']);
        $bookInfo['title'] = htmlspecialchars($book['title']);
        $bookInfo['author'] = htmlspecialchars($book['authorName']);
        $bookInfo['publisher'] = htmlspecialchars($book['publisherName']);
        $bookInfo['copyright'] = htmlspecialchars($book['copyright']);
        $bookInfo['copy'] = htmlspecialchars($book['copy']);
        $bookInfo['status'] = htmlspecialchars($book['stat']);
    }

    if(isset($_POST['updateBook'])){
        $bookInfo['id'] = htmlspecialchars($_POST['id']);
        $bookInfo['accessnum'] = htmlspecialchars($_POST['accessnum']);
        $bookInfo['callnum'] = htmlspecialchars($_POST['callnum']);
        $bookInfo['title'] = htmlspecialchars($_POST['title']);
        $bookInfo['publisher'] = htmlspecialchars($_POST['publisher']);
        $bookInfo['author'] = htmlspecialchars($_POST['author']);
        $bookInfo['copyright'] = htmlspecialchars($_POST['copyright']);
        $bookInfo['status'] = htmlspecialchars($_POST['stat']);

        $result = updateBookTransact($pdo, $bookInfo);
        if( $result == 'success'){
            $_SESSION['status'] = 'ok';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation Successful!';
            $_SESSION['statusText'] = "The book with accession number ".$bookInfo['accessnum']." has been updated successfully.";
            header('Location: bookDashboard.php');
            die();
        }else{
            $_SESSION['status'] = 'failed';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Operation Failed!';
            $_SESSION['statusText'] = $result;
        }
    }

?>

<?php require '../balayanlms/template/header.php';?>
    <?php if($book == 'deleted'):?>
        <?php include '../balayanlms/book/bookNotFound.php';?>
    <?php else:?>
        <div class="container-fluid d-flex justify-content-center my-4">
            <div class="border border-3 border-secondary-subtle rounded m-5 px-3 py-3" id="editBook">
                <h4 class="display-6 text-center py-3">Update <strong>Book</strong></h4>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="needs-validation g-3">
                    <div class="row my-2">
                        <div class="col-6">
                            <img src="../balayanlms/assets/bookCover.jpg" alt="book cover" class="book-cover img-fluid img-thumbnail rounded-3">
                        </div>
                        <div class="col-6">
                            <div class="row my-2">
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forAccessNum">Accession Number</span>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="...." 
                                            aria-label="Accession Number" 
                                            aria-describedby="basic-addon1"
                                            id="accessnum"
                                            name="accessnum"
                                            value="<?php echo $bookInfo['accessnum'];?>"
                                            required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Accession Number!
                                            </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forCallNum">Call Number</span>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="...." 
                                            aria-label="Accession Number" 
                                            aria-describedby="basic-addon1"
                                            id="callnum"
                                            name="callnum"
                                            value="<?php echo $bookInfo['callnum'];?>"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text">Title</span>
                                        <textarea class="form-control" 
                                            aria-label="With textarea"
                                            id="title"
                                            name="title"
                                            required>
                                            <?php echo $bookInfo['title'];?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forPublisher">Publisher</span>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="...." 
                                            aria-label="Publisher" 
                                            aria-describedby="basic-addon1"
                                            id="publisher"
                                            name="publisher"
                                            value="<?php echo $bookInfo['publisher'];?>"
                                            required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Publisher!
                                            </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forAuthor">Author</span>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="...." 
                                            aria-label="Author" 
                                            aria-describedby="basic-addon1"
                                            id="author"
                                            name="author"
                                            value="<?php echo $bookInfo['author'];?>"
                                            required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Author!
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forCopyright">Copyright Year</span>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            placeholder="199x" 
                                            aria-label="copyright" 
                                            aria-describedby="basic-addon1"
                                            id="copyright"
                                            name="copyright"
                                            value="<?php echo $bookInfo['copyright'];?>"
                                            required>
                                            <div class="invalid-feedback">
                                                Please provide a valid Copyright Year!
                                            </div>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="forStatus">Status</span>
                                        <select class="form-select" aria-label="Status" id="stat" name="stat">
                                            <?php foreach($stats as $stat):?>
                                                <?php if($stat['stat'] == $bookInfo['status']):?>
                                                    <option selected value="<?php echo htmlspecialchars($stat['id']);?>">
                                                        <?php echo htmlspecialchars($stat['stat']);?>
                                                    </option>
                                                <?php else:?>
                                                    <option value="<?php echo htmlspecialchars($stat['id']);?>">
                                                        <?php echo htmlspecialchars($stat['stat']);?>
                                                    </option>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col col-12">
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="bookCover">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="bookDashboard.php" class="btn btn-secondary me-1">Back</a>
                                <input type="hidden" id="id" name="id" value="<?php echo $bookInfo['id'];?>">
                                <button type="submit" class="btn btn-danger mx-1" name="updateBook" id="updateBook">Confirm</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif;?>
<?php require '../balayanlms/template/footer.php';?>