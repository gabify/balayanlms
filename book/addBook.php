<?php
    $bookInfo = ['acccessnum'=>'','callnum'=>'','title'=>'','publisher'=>'','author'=>'','copyright'=>''];
    
    if(isset($_POST['addBook'])){
        $bookInfo['accessnum'] = htmlspecialchars($_POST['accessnum']);
        $bookInfo['callnum'] = htmlspecialchars($_POST['callnum']);
        $bookInfo['title'] = htmlspecialchars($_POST['title']);
        $bookInfo['publisher'] = htmlspecialchars($_POST['publisher']);
        $bookInfo['author'] = htmlspecialchars($_POST['author']);
        $bookInfo['copyright'] = htmlspecialchars($_POST['copyright']);

        if(newBookTransact($pdo, $bookInfo) == 'success'){
            $_SESSION['status'] = 'ok';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation Successful!';
            $_SESSION['statusText'] = 'A new book has been added to the collection!';
            //Needs to reload the table after insert, still figuring out hoow to do it.
            header('Location: '.$_SERVER['REQUEST_URI']);
            die();
        }else{
            $_SESSION['status'] = 'failed';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Operation Failed!';
            $_SESSION['statusText'] = 'An error occured. Please try again later!';
        }
    }
?>

<!-- Modal -->
<div 
    class="modal fade" 
    id="addNewBook" 
    data-bs-backdrop="static" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="needs-validation g-3">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 
                    class="modal-title fs-5" 
                    id="AddNewBookLabel">
                        Add New Book
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="addBook" id="addBook">Confirm</button>
            </div>
        </div>
    </form>
</div>

