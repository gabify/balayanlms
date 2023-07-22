<?php 
    $keyword = '';
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_GET['keyword'])){
        $keyword = htmlspecialchars($_GET['keyword']);
    }
?>
<div class="card my-4 mx-4 py-3 px-2">
    <div class="d-flex justify-content-between">
        <h3 class="display-6">Books</h3>
        <div class="d-flex justify-content-between">
            <button 
                class="btn btn-outline-secondary fw-bold"
                data-bs-toggle="modal"
                data-bs-target="#addBook">
                    Add Book
            </button>
        </div>
    </div>
</div>
<div class="card mx-4 mb-3 px-4 pt-4">
    <div class="d-flex justify-content-between mb-2 mx-2">
        <div class="d-flex justify-content-between">
            <div class="lead me-1">Show</div>
            <select name="limit" id="limit" class="form-select">
                <option value="10" selected>10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="lead ms-1">Books</div>
        </div>
        <form id="bookSearch" role="search" method="GET">
            <div class="input-group mb-3">
                <input 
                    class="form-control" 
                    type="search" 
                    placeholder="Search" 
                    aria-label="Search" 
                    id="keyword" 
                    name="keyword" 
                    value="<?php echo htmlspecialchars($keyword);?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
    </div>
    <table class="table table-hover table-bordered text-center" id="bookTable">
        <thead class="fs-5">
            <th scope="col">Accession Number</th>
            <th scope="col">Call Number</th>
            <th scope="col" class="w-50">Title</th>
            <th scope="col">Actions</th>
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
<?php include '../balayanlms/book/createBook.php';?>

