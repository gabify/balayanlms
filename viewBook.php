<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
    }

    if(isset($_POST['submit'])){
        
    }

    function getBook($pdo, $id){
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateBook($pdo, $bookData){
        $stmt = $pdo->prepare("UPDATE books SET
        callnum = :callnum, author = :author, title= :title,
        publisher = :publisher, copyright = :copyright,
        copy= :copy, status = :status WHERE id = :id");
        $stmt->bindParam(':callnum', $bookData['callnum'], PDO::PARAM_STR);
        $stmt->bindParam(':author', $bookData['author'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $bookData['title'], PDO::PARAM_STR);
        $stmt->bindParam(':publisher', $bookData['publisher'], PDO::PARAM_STR);
        $stmt->bindParam(':copyright', $bookData['copyright'], PDO::PARAM_INT);
        $stmt->bindParam(':copy', $bookData['copy'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $bookData['status'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $bookData['id'], PDO::PARAM_INT);

        if($stmt->execute()){
            header("Location: viewBook.php?id=".$bookData['id']);
        }
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <main class="container-fluid px-5 py-5">
        <?php if($book):?>
            <div class="card p-2 m-4">
                <div class="card-body">
                    <h3 class="card-title text-center">
                        Book Information 
                        <button type="button" class="btn" onclick="enableEdit()"><i class="bi-pencil-square fs-5"></i></button>
                    </h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        <div class="row mt-4">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3 mx-5">
                                    <label for="accessnum" class="form-label text-secondary fw-bold">Accession Number</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="accessnum"
                                        name="accessnum" 
                                        value="<?php echo htmlspecialchars($book['id'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="author" class="form-label text-secondary fw-bold">Author</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="author"
                                        name="author" 
                                        value="<?php echo htmlspecialchars($book['author'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="title" class="form-label text-secondary fw-bold">Title</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="title"
                                        name="title" 
                                        value="<?php echo htmlspecialchars($book['title'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="copy" class="form-label text-secondary fw-bold">Copy</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="copy"
                                        name="copy" 
                                        value="<?php echo htmlspecialchars($book['copy'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3 mx-5">
                                    <label for="callnum" class="form-label text-secondary fw-bold">Call Number</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="callnum"
                                        name="callnum" 
                                        value="<?php echo htmlspecialchars($book['callnum'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="publisher" class="form-label text-secondary fw-bold">Publisher</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="publisher"
                                        name="publisher" 
                                        value="<?php echo htmlspecialchars($book['publisher'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="copyright" class="form-label text-secondary fw-bold">Copyright Year</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="copyright"
                                        name="copyright" 
                                        value="<?php echo htmlspecialchars($book['copyright'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="status" class="form-label text-secondary fw-bold">Status</label>
                                    <select class="form-select" aria-label="status" id="status" name="status" disabled>
                                        <?php if($book['status'] == 'Available'):?>
                                            <option value="Available" selected>Avaialble</option>
                                        <?php else:?>
                                            <option value="Available">Available</option>
                                        <?php endif;?>
                                        <?php if($book['status'] == 'Borrowed'):?>
                                            <option value="Borrowed" selected>Borrowed</option>
                                        <?php else:?>
                                            <option value="Borrowed">Borrowed</option>
                                        <?php endif;?>
                                        <?php if($book['status'] == 'Missing'):?>
                                            <option value="Missing" selected>Missing</option>
                                        <?php else:?>
                                            <option value="Missing">Missing</option>
                                        <?php endif;?>
                                        <?php if($book['status'] == 'Weeded-out'):?>
                                            <option value="Weeded-out" selected>Weeded-out</option>
                                        <?php else:?>
                                            <option value="Weeded-out">Weeded-out</option>
                                        <?php endif;?>
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 my-3 d-none buttons">
                                <div class="d-flex justify-content-end">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']);?>">
                                    <button type="submit" class="btn btn-danger mx-1" name="submit" id="submitBtn">Update</button>
                                    <button type="button" class="btn btn-secondary mx-1" onclick="disableEdit()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card p-2 m-4">
                <div class="card-body">
                    <h3 class="card-title text-center">Book History</h3>
                    <p class="text-center mt-5 fs-5">No history to show</p>
                    <div class="d-flex justify-content-center">
                        <img src="../balayanlms/assets/web_search.svg" alt="no history" class="img-fluid w-50">
                    </div>
                </div>
            </div>
        <?php else:?>
            <?php include '../balayanlms/book/bookNotFound.php';?>    
        <?php endif;?>
    </main>
    <?php require '../balayanlms/template/footer.php';?>
    <script src="../balayanlms/book/deleteBook.js"></script>
    <script>
        const inputs = document.querySelectorAll('.form-control');
        const status = document.querySelector('#status');
        const buttons = document.querySelector('.buttons');

        const enableEdit = () =>{
            inputs.forEach(input =>{
                if(input.getAttribute("name") != 'accessnum'){
                    input.disabled = false; 
                }
            });
            status.disabled = false;
            buttons.classList.remove("d-none");
        }
        const disableEdit = () =>{
            inputs.forEach(input =>{
                if(input.getAttribute("name") != 'accessnum'){
                    input.disabled = true; 
                }
            });
            status.disabled = true;
            buttons.classList.add("d-none");
        }
    </script>
    </body>
</html>