<?php 
session_start();

$pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
require '../balayanlms/book/bookHandler.php';

$books = getAllBooks($pdo);

?>

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
        <div 
            class="tab-pane fade show active" 
            id="tableViewContent" role="tabpanel" 
            aria-labelledby="home-tab" 
            tabindex="0">
            <div class="row my-3 mx-2">
                <div class="col-4">
                    Show 
                    <form action="" class="d-inline-block mx-1">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </form>
                    Entries
                </div>
                <div class="col-4">
                    <h3 class="display-6 text-center">Book <strong>Details</strong></h3>
                </div>
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <button 
                                class="btn btn-outline-secondary fw-bold fs-6 d-inline-block"
                                data-bs-toggle="modal"
                                data-bs-target="#addNewBook">
                                    Add New
                                    <i class="bi-plus fs-5 fw-bold align-middle"></i>
                            </button>
                        </div>
                        <div class="col-8">
                            <form class="d-flex justify-content-end" role="search">
                                <div class="input-group mb-3">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-bordered">
                <thead class="">
                    <tr class="text-center fs-5">
                        <th scope="col">Accession #</th>
                        <th scope="col">Call Number</th>
                        <th scope="col">Title</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach($books as $book):?>
                        <tr class="text-center">
                            <td><?php echo htmlspecialchars($book['accessnum']);?></td>
                            <td><?php echo htmlspecialchars($book['callnum']);?></td>
                            <td><?php echo htmlspecialchars($book['title']);?></td>
                            <td>
                                <a href="#" class="btn"><i class="bi-eye-fill fs-4 text-primary"></i></a>
                                <a href="#" class="btn"><i class="bi-pencil-fill fs-4 text-warning"></i></a>
                                <a href="#" class="btn"><i class="bi-trash3-fill fs-4 text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="container-fluid my-2 g-0">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <div class="col col-4">
                            <div class="my-1">
                                Showing 0 out of 200 entries
                            </div>
                        </div>
                        <div class="col col-4">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item"><a class="page-link text-dark" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link text-dark" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
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


<!-- Modal for Adding new book -->
<?php include '../balayanlms/book/addBook.php';?>
