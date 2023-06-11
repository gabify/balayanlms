<?php 
    session_start();

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    require '../balayanlms/book/bookHandler.php';

    $page_no = 1;
    if(isset($_GET['page_no'])){
        $page_no = $_GET['page_no'];
    }
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
        <!--Table View -->
        <?php include '../balayanlms/book/bookTableView.php';?>
        
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

