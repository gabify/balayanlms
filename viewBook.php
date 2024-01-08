<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $bookData = array("id" =>'',
    "callnum" => "",
    "author" => "",
    "title" => "",
    "publisher" => "",
    "copyright" => "",
    "copy" => "",
    "status" => "");

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
        $book = getBook($pdo, $id);
        $studentBookHistory = getBookHistoryStudent($pdo, $id);
        $facultyBookHistory = getBookHistoryFaculty($pdo, $id);
        $bookHistory = array_merge($studentBookHistory, $facultyBookHistory);
    }

    if(isset($_POST['submit'])){
        $bookData['id'] = htmlspecialchars($_POST['accessnum']);
        $bookData['callnum'] = htmlspecialchars($_POST['callnum']);
        $bookData['author'] = htmlspecialchars($_POST['author']);
        $bookData['title'] = htmlspecialchars($_POST['title']);
        $bookData['publisher'] = htmlspecialchars($_POST['publisher']);
        $bookData['copyright'] = htmlspecialchars($_POST['copyright']);
        $bookData['copy'] = htmlspecialchars($_POST['copy']);
        $bookData['status'] = htmlspecialchars($_POST['status']);
        updateBook($pdo, $bookData);

    }

    function getBook($pdo, $id){
        $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id AND is_deleted = 0");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getBookHistoryStudent($pdo, $id){
        $stmt = $pdo->prepare("SELECT user.first_name,
        user.last_name,
        book_borrow.user_type,
        book_borrow.date_borrowed,
        book_borrow.date_returned,
        book_borrow.is_returned
        FROM student JOIN book_borrow
        ON student.id = book_borrow.user_id
        JOIN user ON student.user_id = user.id
        WHERE book_borrow.book_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getBookHistoryFaculty($pdo, $id){
        $stmt = $pdo->prepare("SELECT user.first_name,
        user.last_name,
        book_borrow.user_type,
        book_borrow.date_borrowed,
        book_borrow.date_returned,
        book_borrow.is_returned
        FROM faculty JOIN book_borrow
        ON faculty.id = book_borrow.user_id
        JOIN user ON faculty.user_id = user.id
        WHERE book_borrow.book_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'The book has been successfully updated.';
            header("Location: viewBook.php?id=".$bookData['id']);
            exit();
        }else{
            $_SESSION['status'] = 'error';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Operation failed';
            $_SESSION['statusText'] = 'An error occured. Please try again later.';
        }
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <main class="w-75 mx-auto p-5">
        <?php if($book):?>
            <div class="card p-2 m-4" style="background-color: #E3E9F7;">
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
                                        readonly>
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
            <div class="card p-2 m-4" style="background-color: #E3E9F7;">
                <?php if($bookHistory):?>
                    <div class="card-body">
                        <h3 class="card-title text-center">Book History</h3>
                        <table class="table table-bordered table-hover">
                            <thead class="table-danger">
                                <tr>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Date Borrowed</th>
                                    <th scope="col">Date Returned</th>
                                    <th scope="col">Is Returned</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($bookHistory as $history):?>
                                    <tr class="text-center">
                                        <td><?php echo $history['first_name']?></td>
                                        <td><?php echo $history['last_name']?></td>
                                        <td><?php echo $history['user_type']?></td>
                                        <td><?php echo $history['date_borrowed']?></td>
                                        <td><?php echo $history['date_returned']?></td>
                                        <td>
                                            <?php if($history['is_returned'] == 0):?>
                                                <?php echo 'No'?>
                                            <?php else:?>
                                                <?php echo 'Yes'?>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="bookDashboard.php" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                <?php else:?>
                    <div class="card-body">
                        <h3 class="card-title text-center">Book History</h3>
                        <p class="text-center mt-5 fs-5">No history to show</p>
                        <div class="d-flex justify-content-center">
                            <img src="../balayanlms/assets/web_search.svg" alt="no history" class="img-fluid w-25">
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="bookDashboard.php" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                <?php endif;?>
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