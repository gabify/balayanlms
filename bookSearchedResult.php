<?php
    session_start();

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    $page_num = 1;
    $total_record_per_page = 10;
    $totalPages = getTotalPages($pdo, $total_record_per_page);
    $offset = ($page_num - 1) * $total_record_per_page;
    $previous_page = $page_num - 1;
    $next_page = $page_num + 1;
    $keyword = htmlspecialchars($_GET['keyword']);
    $keyword = '%'.$keyword.'%';
    if(isset($_GET['page_num'])){
        $page_num = htmlspecialchars($_GET['page_num']);
    }

    //$books = getBooks($pdo, $offset, $total_record_per_page, $keyword);

?>
<?php require '../balayanlms/template/header.php';?>
    <div class="row my-3 mt-5 mx-4 d-flex justify-content-between">
        <div class="col-3">
            <h3 class="display-6">Books</h3>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-4">
                    <a 
                        class="btn btn-outline-secondary fw-bold fs-6 d-inline-block"
                        href="../balayanlms/addBook.php">
                            Add New
                            <i class="bi-plus fs-5 fw-bold align-middle"></i>
                    </a>
                </div>
                <div class="col-8">
                    <form class="d-flex justify-content-end" role="search" method="GET" action="../balayanlms/bookSearchedResult.php">
                        <div class="input-group mb-3">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="keyword" name="keyword">
                            <button class="btn btn-outline-secondary" type="submit" id="search" name="search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4 px-4 g-0">
        <ul class="nav nav-tabs" id="optionTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link active text-dark" 
                    id="tableView" 
                    data-bs-toggle="tab" 
                    data-bs-target="#tableViewContent" 
                    type="button" role="tab" 
                    aria-controls="table-tab-pane" 
                    aria-selected="true">
                        <i class="bi-table"></i>
                        Table View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link text-dark" 
                    id="listView" 
                    data-bs-toggle="tab" 
                    data-bs-target="#listViewContent" 
                    type="button" role="tab" 
                    aria-controls="list-tab-pane" 
                    aria-selected="true">
                        <i class="bi-list-task"></i>
                        List View
                </button>
            </li>
        </ul>

        <div class="tab-content px-2 pt-2" id="myTabContent">
            <!--Table View -->
            <div 
                class="tab-pane fade show active" 
                id="tableViewContent" role="tabpanel" 
                aria-labelledby="home-tab" 
                tabindex="0">
                This is table
            </div>
            
            <!--List View -->
            <div 
                class="tab-pane fade" 
                id="listViewContent" 
                role="tabpanel" 
                aria-labelledby="profile-tab" 
                tabindex="0">
                    Another text here
                    
            </div>
        </div>
    </div>
<?php require '../balayanlms/template/footer.php';?>