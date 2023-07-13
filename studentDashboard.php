<?php 
    if(!isset($_SESSION)){
        session_start();
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="my-2 mt-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">    
            <h3 class="display-6 my-2">List of students</h3>
            <form class="mt-3" id="studentSearch" role="search" method="GET">
                <div class="input-group mb-3">
                    <input 
                        class="form-control" 
                        type="search" 
                        placeholder="Search" 
                        aria-label="Search" 
                        id="keyword" 
                        name="keyword" 
                        value="">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="my-3 mx-4 px-4 py-3 card">
        <div class="mb-2 row">
            <div class="col-8">
                <div class="row">
                    <div class="col-1 lead">Show</div>
                    <div class="col-2">
                        <select name="limit" id="limit" class="form-select">
                            <option value="10" selected>10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-2 lead">Students</div>
                </div>
            </div>
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
    </div>
<?php require '../balayanlms/template/footer.php';?>
    <script src="../balayanlms/student/studentDataTable.js"></script>
</body>
</html>