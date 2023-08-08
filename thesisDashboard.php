<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    $page = 1;
    $keyword = '';
    if(isset($_GET['page'])){
        $page = htmlspecialchars($_GET['page']);
    }
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <div class="my-2 mt-3 mx-4 px-4 py-3 card">
        <div class="d-flex justify-content-between">    
            <h3 class="display-6 my-2">List of Thesis</h3>
            <button type="button" class="btn btn-danger my-2" data-bs-toggle="modal" data-bs-target="#addThesis">
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
                <div class="lead">Theses</div>
            </div>
            <form id="thesisSearch" role="search" method="GET">
                <div class="input-group mb-3">
                    <input 
                        class="form-control" 
                        type="search" 
                        placeholder="Search here..." 
                        aria-label="Search" 
                        id="keyword" 
                        name="keyword" 
                        value="<?php echo htmlspecialchars($keyword);?>">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>
        <table class="table table-hover table-bordered text-center my-2" id="thesisTable">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Call Number</th>
                <th scope="col">Title</th>
                <th scope="col">Publication Year</th>
                <th scope="col">Actions</th>
            </thead>
        </table>
        <div class="d-flex justify-content-end mt-2">
            <nav aria-label="Thesis Pagination">
                <ul class="pagination">
                </ul>
            </nav>
            <input type="hidden" name="page" id="page" value="<?php echo htmlspecialchars($page)?>">
        </div>
    </div>

    <div class="modal fade" id="addThesis" tabindex="-1" aria-labelledby="add student" aria-hidden="true">
        <div class="modal-dialog">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="addNewThesis">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="mb-3">
                            <label for="callnum" class="form-label fw-bold text-secondary">Call Number</label>
                            <input type="text" class="form-control ms-1" id="callnum" name="callnum">
                            <small class="error-message text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold text-secondary">Title</label>
                            <input type="text" class="form-control ms-1" id="title" name="title">
                            <small class="error-message text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label fw-bold text-secondary">Authors</label>
                            <input type="text" class="form-control ms-1" id="author" name="author">
                            <small class="error-message text-danger"></small>
                        </div>
                        <div class="mb-3">
                            <label for="adviser" class="form-label fw-bold text-secondary">Adviser</label>
                            <input type="text" class="form-control ms-1" id="adviser" name="adviser">
                            <small class="error-message text-danger"></small>
                        </div>
                        <div class="mb-4">
                            <label for="publicationYear" class="form-label fw-bold text-secondary">Publication Year</label>
                            <input type="text" class="form-control ms-1" id="publicationYear" name="publicationYear">
                            <small class="error-message text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" id="submitBtn" class="btn btn-danger">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php require '../balayanlms/template/footer.php';?>
<script src="../balayanlms/thesis/thesis_datatable.js"></script>
<script src="../balayanlms/thesis/add_thesis.js"></script>
</body>
</html>