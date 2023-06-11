<?php 
    session_start();
    $pdo = require '../balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    $bookInfo = ['acccessnum'=>'','callnum'=>'','title'=>'','publisher'=>'','author'=>'','copyright'=>''];
    
    if(isset($_POST['addBook'])){
        $bookInfo['accessnum'] = htmlspecialchars($_POST['accessnum']);
        $bookInfo['callnum'] = htmlspecialchars($_POST['callnum']);
        $bookInfo['title'] = htmlspecialchars($_POST['title']);
        $bookInfo['publisher'] = htmlspecialchars($_POST['publisher']);
        $bookInfo['author'] = htmlspecialchars($_POST['author']);
        $bookInfo['copyright'] = htmlspecialchars($_POST['copyright']);

        $result = newBookTransact($pdo, $bookInfo);
        if($result == 'success'){
            $_SESSION['status'] = 'ok';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation Successful!';
            $_SESSION['statusText'] = 'A new book has been added to the collection!';
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
<div class="container-fluid d-flex justify-content-center my-4">
    <div class="border border-3 border-secondary-subtle rounded m-5 px-5 py-3" id="addBook">
        <h4 class="display-6 text-center py-3">Add New <strong>Book</strong></h4>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="needs-validation g-3">
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
                            aria-label="Publisher" 
                            aria-describedby="basic-addon1"
                            id="author"
                            name="author"
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
                        <span class="input-group-text" id="acnum">Copyright Year</span>
                        <input 
                            type="text" 
                            class="form-control" 
                            placeholder="199x" 
                            aria-label="Accession Number" 
                            aria-describedby="basic-addon1"
                            id="copyright"
                            name="copyright"
                            required>
                            <div class="invalid-feedback">
                                Please provide a valid Copyright Year!
                            </div>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="accessnum">Copy</span>
                        <input 
                            type="text" 
                            class="form-control"  
                            aria-label="Accession Number" 
                            aria-describedby="basic-addon1"
                            id="copy"
                            name="copy"
                            value="1"
                            readonly>
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
                <button type="submit" class="btn btn-danger mx-1" name="addBook" id="addBook">Confirm</button>
            </div>
        </form>
    </div>
</div>
<?php require '../balayanlms/template/footer.php';?>

