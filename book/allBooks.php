<?php 
    session_start();
?>
<div class="row my-3 mt-5 mx-4 d-flex justify-content-between">
    <div class="col-3">
        <h3 class="display-6">Books</h3>
    </div>
    <div class="col-4">
        <div class="row">
            <div class="col-4">
                <button 
                    class="btn btn-outline-secondary fw-bold fs-6 d-inline-block"
                    data-bs-toggle="modal"
                    data-bs-target="#addBook">
                        Add New
                        <i class="bi-plus fs-5 fw-bold align-middle"></i>
                </button>
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
<div class="container-fluid mt-4 px-4">
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
            class="tab-pane fade mx-3 my-3 py-3 d-flex justify-content-center show active" 
            id="tableViewContent" 
            role="tabpanel" 
            aria-labelledby="profile-tab" 
            tabindex="0">
                <?php include '../balayanlms/book/bookTable.php';?>
                
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
<?php include '../balayanlms/book/createBook.php';?>

