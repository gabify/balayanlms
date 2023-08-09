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
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="my-2 mt-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">    
            <h3 class="display-6 my-2">List of faculties</h3>
            <button type="button" class="btn btn-danger my-2" data-bs-toggle="modal" data-bs-target="#addFaculty">
                Add new
        </div>
    </div>
    <div class="my-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-evenly">
                <div class="lead mt-2">Show</div>
                <select name="limit" id="limit" class="form-select mx-2">
                    <option value="10" selected>10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <div class="lead mt-2">Faculties</div>
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
                    <button class="btn btn-danger" type="submit">Search</button>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered text-center my-2" id="facultyTable">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Employee number</th>
                <th scope="col">Last name</th>
                <th scope="col">First Name</th>
                <th scope="col">Actions</th>
            </thead>
        </table>
        <div class="d-flex justify-content-end mt-2">
            <nav aria-label="Faculty Pagination">
                <ul class="pagination">
                </ul>
            </nav>
            <input type="hidden" name="page" id="page" value="<?php echo htmlspecialchars($page)?>">
        </div>
    </div>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>