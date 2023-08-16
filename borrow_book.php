<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    $userType = '';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_GET['user_type'])){
        $userType = htmlspecialchars($_GET['user_type']);
    }

    function getUser($pdo, $id, $userType){
        if($userType == 'student'){
            $stmt = $pdo->prepare("SELECT user.id,
            user.first_name,
            user.last_name,
            student.srcode,
            student.program,
            user.borrowed_books 
            FROM student JOIN user 
            ON student.user_id = user.id
            WHERE student.id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            return $student;
        }else if($userType == 'faculty'){
            $stmt = $pdo->prepare("SELECT user.id,
            user.first_name,
            user.last_name,
            faculty.employee_num,
            user.borrowed_books
            FROM faculty JOIN user
            ON faculty.user_id = user.id 
            WHERE faculty.id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
            return $faculty;
        }
    }
    $user = getUser($pdo, $id, $userType);
?>
<?php require '../balayanlms/template/header.php';?>
    <section class="card m-4">
        <div class="card-body p-4">
            <h5 class="card-title text-center mb-3">Select Books</h5>
            <div class="d-flex justify-content-end mb-1 mx-2">
                <form id="bookSearch" role="search">
                    <div class="input-group mb-3">
                        <input 
                            class="form-control" 
                            type="search" 
                            placeholder="Search" 
                            aria-label="Search" 
                            id="keyword" 
                            name="keyword">
                        <button class="btn btn-danger" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <table class="table table-hover table-bordered text-center" id="bookTable">
                <thead>
                    <th scope="col">Accession Number</th>
                    <th scope="col" class="w-50">Title</th>
                </thead>
            </table>
            <!-- Pagination -->
            <div class="d-flex justify-content-between my-2">
                <div class="lead" id="pageInfo"></div>
                <nav aria-label="book pagination">
                    <ul class="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <section class="card m-4 p-3">
        <div class="card-body">
            <h5 class="card-title text-center">Borrower's Form</h5>
            <div class="row px-5 mt-4">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label text-secondary fw-bold">First Name</label>
                        <input type="text" 
                            class="form-control" 
                            id="first_name" 
                            name="first_name"
                            value="<?php echo htmlspecialchars($user['first_name'])?>"
                            disabled>
                            <span class="text-danger"></span>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label text-secondary fw-bold">Last Name</label>
                        <input type="text" 
                            class="form-control" 
                            id="last_name" 
                            name="last_name"
                            value="<?php echo htmlspecialchars($user['last_name'])?>"
                            disabled>
                            <span class="text-danger"></span>
                    </div>
                </div>
                <?php if($userType == 'student'):?>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="srcode" class="form-label text-secondary fw-bold">Srcode</label>
                            <input type="text" 
                                class="form-control" 
                                id="srcode" 
                                name="srcode"
                                value="<?php echo htmlspecialchars($user['srcode'])?>"
                                disabled>
                                <span class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label for="program" class="form-label text-secondary fw-bold">Program</label>
                            <input type="text" 
                                class="form-control" 
                                id="program" 
                                name="program"
                                value="<?php echo htmlspecialchars($user['program'])?>"
                                disabled>
                                <span class="text-danger"></span>
                        </div>
                    </div>
                <?php elseif($userType == 'faculty'):?>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="srcode" class="form-label text-secondary fw-bold">Employee Number</label>
                            <input type="text" 
                                class="form-control" 
                                id="employeeNum" 
                                name="employeeNum"
                                value="<?php echo htmlspecialchars($user['employee_num'])?>"
                                disabled>
                                <span class="text-danger"></span>
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <table class="table table-hover table-bordered text-center mt-3" id="toBorrowedBooks">
                <thead>
                    <th scope="col">Accession Number</th>
                    <th scope="col" class="w-50">Title</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <input type="hidden" name="borrowedBooks" id="borrowedBooks" value="<?php echo htmlspecialchars($user['borrowed_books'])?>">
            <input type="hidden" name="userType" id="userType" value="<?php echo htmlspecialchars($userType)?>">
            <input type="hidden" name="currentPage" id="currentPage" value="1">
        </div>
    </section>
<?php require '../balayanlms/template/footer.php';?>
<script src="../balayanlms/borrow/book_datatable.js"></script>
</body>
</html>
