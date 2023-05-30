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
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr class="text-center fs-5">
                            <th scope="col">Accession Number</th>
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
                                    <button class="btn btn-primary">View</button>
                                    <button class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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