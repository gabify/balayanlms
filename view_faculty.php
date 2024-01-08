<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_POST['submit'])){
        $id = htmlspecialchars($_POST['id']);
        $firstname = htmlspecialchars($_POST['first_name']);
        $lastname = htmlspecialchars($_POST['last_name']);
        $employeeNum = htmlspecialchars($_POST['employeeNum']);

        $stmt = $pdo->prepare("UPDATE faculty INNER JOIN user 
        ON faculty.user_id = user.id
        SET user.first_name = :first_name,
        user.last_name = :last_name,
        faculty.employee_num = :employeeNum
        WHERE faculty.id = :id");
        $stmt->bindParam(':first_name', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':employeeNum', $employeeNum, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'The information of faculty has been updated';
            header("Location:view_faculty.php?id=".$id);
            exit();
        }else{
            $_SESSION['status'] = 'error';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Error';
            $_SESSION['statusText'] = 'An error occured during operation. ';
        }
    }
    function getFaculty($pdo, $id){
        $stmt =$pdo->prepare("SELECT faculty.id,
        user.first_name,
        user.last_name,
        faculty.employee_num
        FROM faculty
        JOIN user ON faculty.user_id = user.id
        WHERE faculty.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }
    function getFacultyHistory($pdo, $id, $offset, $historyPerPage, $userType){
        $stmt = $pdo->prepare("SELECT book_borrow.id,
        book_borrow.book_id, 
        books.callnum,
        books.title,
        book_borrow.date_borrowed,
        book_borrow.date_returned,
        book_borrow.is_returned
        FROM book_borrow JOIN books
        ON book_borrow.book_id = books.id
        WHERE book_borrow.user_id = :id 
        AND user_type = :userType  
        LIMIT :offset, :total_record_per_page");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':userType', $userType, PDO::PARAM_STR);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':total_record_per_page', $historyPerPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getNumberOfBorrowedBooks($pdo, $id, $historyPerPage){
        $stmt = $pdo->prepare("SELECT COUNT(book_borrow.id)
        AS NumofBorrowedBooks FROM book_borrow
        WHERE book_borrow.user_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ceil($result['NumofBorrowedBooks']/$historyPerPage);
    }
    $faculty = getFaculty($pdo, $id);
    $historyPerPage = 10;
    $page_num = 1;

    if(isset($_GET['page'])){
        $page_num = htmlspecialchars($_GET['page']);
    }
    $offset = (intval($page_num) - 1) * $historyPerPage;
    $next = intval($page_num) + 1;
    $prev = intval($page_num) - 1;
    $adjacent = 2;
    $totalPage = getNumberOfBorrowedBooks($pdo, $id, $historyPerPage);
    $secondToLast = $totalPage - 1;
    $studentHistory = getFacultyHistory($pdo, $id, $offset, $historyPerPage, 'faculty');
?>
<?php require '../balayanlms/template/header.php';?>
    <?php if($faculty):?>
        <section class="card my-4 mx-auto w-75">
            <div class="row">
                <div class="col-4 border-end border-dark-subtle">
                    <div class="row">
                        <di class="col-12 px-5 py-4">
                            <img src="../balayanlms/assets/male.svg" class="img-fluid" alt="no result" width="250px">
                        </di>
                        <div class="col-12 px-5 py-3">
                            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" id="edit_form">
                                <p class="text-center mt-3 fs-5 fw-bold">Faculty's Information 
                                    <i class="bi-pencil-square text-danger" onclick="enableEdit()" style="cursor: pointer;"></i>
                                </p>
                                <div class="mb-3">
                                    <label for="srcode" class="form-label text-secondary fw-bold">Employee Number</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="employeeNum"
                                        name="employeeNum" 
                                        value="<?php echo htmlspecialchars($faculty['employee_num'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label text-secondary fw-bold">First Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="first_name" 
                                        name="first_name"
                                        value="<?php echo htmlspecialchars($faculty['first_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label text-secondary fw-bold">Last Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="last_name"
                                        name="last_name" 
                                        value="<?php echo htmlspecialchars($faculty['last_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="buttons d-none my-3">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($faculty['id']);?>">
                                    <button type="submit" class="btn btn-danger" name="submit" id="submitBtn">Update</button>
                                    <button type="button" class="btn btn-secondary" onclick="disableEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8 p-4">
                    <div class="d-flex justify-content-end">
                        <a href="facultyDashboard.php" class="btn btn-danger">Back</a>
                    </div>
                    <h3 class="display-5 text-center mb-5">Faculty's History</h3>
                    <?php if($studentHistory):?>
                        <table class="table table-bordered table-hover">
                            <thead class="table-danger">
                                <tr class="text-center">
                                    <th scope="col">Call Number</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date Borrowed</th>
                                    <th scope="col">Date Returned</th>
                                    <th scope="col">Is Returned</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($studentHistory as $history):?>
                                    <tr class="text-center">
                                        <td><?php echo $history['callnum'];?></td>
                                        <td><?php echo $history['title'];?></td>
                                        <td><?php echo $history['date_borrowed'];?></td>
                                        <td><?php echo $history['date_returned'];?></td>
                                        <td><?php echo $history['is_returned'] == 0 ? 'No': 'Yes' ?></td>
                                        <td>
                                            <?php if($history['is_returned'] == 0):?>
                                                <a href="return_book_faculty.php?id=<?php echo $faculty['id'];?>&book-transact=<?php echo $history['id'];?>&book-id=<?php echo $history['book_id'];?>" class="btn btn-danger">Return</a>
                                            <?php else:?>
                                                <a class="btn btn-danger disabled">Return</a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                       <div class="d-flex justify-content-end">
                        <nav aria-label="Pagination of book history">
                                <ul class="pagination">
                                    <?php if($page_num == 1):?>
                                        <li class="page-item disabled"><a class="page-link">Previous</a></li>
                                    <?php else:?>
                                        <li class="page-item">
                                            <a class="page-link text-dark" 
                                            href="?id=<?php echo $id;?>&page=<?php echo $prev;?>">Previous</a>
                                        </li>
                                    <?php endif;?>
                                    <?php if($totalPage <= 10):?>
                                        <?php for($counter = 1; $counter <= $totalPage; $counter++):?>
                                            <?php if($counter == $page_num):?>
                                                <li class="page-item active" aria-current="page">
                                                    <a class="page-link"><?php echo $counter;?></a>
                                                </li>
                                            <?php else:?>
                                                <li class="page-item">
                                                    <a class="page-link text-dark" 
                                                    href="?id=<?php echo $id;?>&page=<?php echo $counter;?>"><?php echo $counter;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endfor;?>
                                    <?php elseif($totalPage > 10):?>
                                        <?php if($page_num < 4):?>
                                            <?php for($counter = 1; $counter < 8; $counter++):?>
                                                <?php if($counter == $page_num):?>
                                                    <li class="page-item active" aria-current="page">
                                                        <a class="page-link"><?php echo $counter;?></a>
                                                    </li>
                                                <?php else:?>
                                                    <li class="page-item">
                                                        <a class="page-link text-dark" 
                                                        href="?id=<?php echo $id;?>&page=<?php echo $counter;?>"><?php echo $counter;?></a>
                                                    </li>
                                                <?php endif;?>
                                            <?php endfor;?>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link text-dark">.....</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=<?php echo $secondToLast;?>"><?php echo $secondToLast;?></a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=<?php echo $totalPage;?>"><?php echo $totalPage;?></a>
                                            </li>
                                        <?php elseif($page_num > 4 && $page_num < $totalPage - 4):?>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=1">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=2">2</a>
                                            </li>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link text-dark">.....</a>
                                            </li>
                                            <?php for($counter = $page_num - $adjacents; $counter <= $page_num + $adjacents; $counter++):?>
                                                <?php if($counter == $page_num):?>
                                                    <li class="page-item active" aria-current="page">
                                                        <a class="page-link"><?php echo $counter;?></a>
                                                    </li>
                                                <?php else:?>
                                                    <li class="page-item">
                                                        <a class="page-link text-dark" 
                                                        href="?id=<?php echo $id;?>&page=<?php echo $counter;?>"><?php echo $counter;?></a>
                                                    </li>
                                                <?php endif;?>
                                            <?php endfor;?>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link text-dark">.....</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=<?php echo $secondToLast;?>"><?php echo $secondToLast;?></a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=<?php echo $totalPage;?>"><?php echo $totalPage;?></a>
                                            </li>
                                        <?php else:?>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=1">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link text-dark" 
                                                href="?id=<?php echo $id;?>&page=2">2</a>
                                            </li>
                                            <li class="page-item" aria-current="page">
                                                <a class="page-link text-dark">.....</a>
                                            </li>
                                            <?php for($counter = $totalPage - 6; $counter <= $totalPage; $counter++):?>
                                                <?php if($counter == $page_num):?>
                                                    <li class="page-item active" aria-current="page">
                                                        <a class="page-link"><?php echo $counter;?></a>
                                                    </li>
                                                <?php else:?>
                                                    <li class="page-item">
                                                        <a class="page-link text-dark" 
                                                        href="?id=<?php echo $id;?>&page=<?php echo $counter;?>"><?php echo $counter;?></a>
                                                    </li>
                                                <?php endif;?>
                                            <?php endfor;?>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <?php if($page_num == $totalPage):?>
                                        <li class="page-item disabled"><a class="page-link">Next</a></li>
                                    <?php else:?>
                                        <li class="page-item">
                                            <a class="page-link text-dark" 
                                            href="?id=<?php echo $id;?>&page=<?php echo $next;?>">Next</a>
                                        </li>
                                    <?php endif;?>
                                </ul>
                            </nav>
                       </div>
                    <?php else:?>
                        <p class="fs-4 mb-0 text-center">No history for this faculty</p>
                        <div class="d-flex justify-content-center">
                            <img src="../balayanlms/assets/web_search.svg" class="img-fluid" alt="no result" width="330px">
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </section>
    <?php else:?>
        <div class="m-3 p3">
            <h3 class="display-5 text-center my-3">No such student exist.</h3>
            <div class="d-flex justify-content-center">
                <img src="../balayanlms/assets/web_search.svg" class="img-fluid w-50" alt="no result">
            </div>
        </div>
    <?php endif;?>
<?php require '../balayanlms/template/footer.php';?>
        <script>
            const inputs = document.querySelectorAll('.form-control');
            const buttons = document.querySelector('.buttons');

            const enableEdit = () =>{
                buttons.classList.remove("d-none");
                inputs.forEach(input =>{
                    input.disabled = false;
                    
                });
            }

            const disableEdit = () =>{
                buttons.classList.add("d-none");
                inputs.forEach(input =>{
                    input.disabled = true;
                    
                });
            }

            const setError = (element, message) =>{
                const errorMessage = element.nextElementSibling;
                const label = element.previousElementSibling;

                errorMessage.innerText = message;
                label.classList.add("text-danger");
                element.classList.add("border-danger");
            }
            const setSuccess = (element) =>{
                const errorMessage = element.nextElementSibling;
                const label = element.previousElementSibling;

                errorMessage.innerText = "";
                label.classList.remove("text-danger");
                element.classList.remove("border-danger");
            }

            const isEmpty = (element) => {
                if(element.value === ''){
                    return true;
                }
                return false;
            }

            const validate = () =>{
                const employeeNum = inputs[0];
                const firstName = inputs[1];
                const lastName = inputs[2];

                if(isEmpty(employeeNum)){
                    setError(employeeNum, 'Please provide an employee number');
                    return false;
                }else{
                    setSuccess(employeeNum);
                }
                if(isEmpty(firstName)){
                    setError(firstName, 'Please provide a first name');
                    return false;
                }else{
                    setSuccess(firstName);
                }
                if(isEmpty(lastName)){
                    setError(lastName, 'Please provide a last name');
                    return false;
                }else{
                    setSuccess(lastName);
                }
                return true;
            }

            const form = document.querySelector('#edit_form');
            form.addEventListener('submit', e =>{
                if(!validate()){
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        </script>
</body>
</html>