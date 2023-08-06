<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    $keyword = 'null';
    $page = 1;
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
    }
    //will add add student function
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="my-2 mt-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">    
            <h3 class="display-6 my-2">List of students</h3>
            <button type="button" class="btn btn-danger my-2" data-bs-toggle="modal" data-bs-target="#addStudent">
                Add new
        </div>
    </div>
    <div class="my-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-evenly">
                <div class="lead">Show</div>
                <select name="limit" id="limit" class="form-select mx-1">
                    <option value="10" selected>10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <div class="lead">Students</div>
            </div>
            <form id="studentSearch" role="search" method="GET">
                <div class="input-group mb-3">
                    <input 
                        class="form-control" 
                        type="search" 
                        placeholder="Search here..." 
                        aria-label="Search" 
                        id="keyword" 
                        name="keyword" 
                        value="">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered text-center my-2" id="studentTable">
            <thead class="fs-5">
                <th scope="col">#</th>
                <th scope="col">Sr-code</th>
                <th scope="col">Last name</th>
                <th scope="col">First Name</th>
                <th scope="col">Program</th>
                <th scope="col">Actions</th>
            </thead>
        </table>
        <div class="d-flex justify-content-end mt-2">
            <nav aria-label="Student Pagination">
                <ul class="pagination">
                </ul>
            </nav>
            <input type="hidden" name="page" id="page" value="<?php echo htmlspecialchars($page)?>">
        </div>
    </div>

    <div class="modal fade" id="addStudent" tabindex="-1" aria-labelledby="add student" aria-hidden="true">
        <div class="modal-dialog">
            <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="me-1">
                                <label for="srcode" class="form-label fw-bold text-secondary">Srcode</label>
                                <input type="text" class="form-control" id="srcode" name="srcode" placeholder="ex. 12-34567" required>
                                <small class="error-message text-danger"></small>
                            </div>
                            <div class="ms-1">
                                <label for="program" class="form-label fw-bold text-secondary">Program</label>
                                <select class="form-select" aria-label="Programs" id="program" name="program" required>
                                    <option selected disabled value="">Choose program..</option>
                                    <option value="CIT">CIT</option>
                                    <option value="CTE">CTE</option>
                                    <option value="CICS">CICS</option>
                                </select>
                                <small class="error-message text-danger"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label fw-bold text-secondary">First Name</label>
                            <input type="text" class="form-control ms-1" id="firstname" name="firstname" placeholder="ex. Juan" required>
                            <small class="error-message text-danger"></small>
                        </div>
                        <div class="mb-4">
                            <label for="lastname" class="form-label fw-bold text-secondary">Last Name</label>
                            <input type="text" class="form-control ms-1" id="lastname" name="lastname" placeholder="ex. Dela Cruz" required>
                            <small class="error-message text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php require '../balayanlms/template/footer.php';?>
    <script src="../balayanlms/student/studentDataTable.js"></script>
</body>
</html>