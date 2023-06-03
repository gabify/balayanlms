<?php

$publishers = getAllPublishers($pdo);
$authors = getAllAuthors($pdo);

?>

<!-- Modal -->
<div 
    class="modal fade" 
    id="addNewBook" 
    data-bs-backdrop="static" 
    data-bs-keyboard="false" 
    tabindex="-1" 
    aria-labelledby="staticBackdropLabel" 
    aria-hidden="true">
    <form action="">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 
                    class="modal-title fs-5" 
                    id="AddNewBookLabel">
                        Add New Book
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row my-2">
                        <div class="col col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="acnum">Accession Number</span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="...." 
                                    aria-label="Accession Number" 
                                    aria-describedby="basic-addon1"
                                    id="accessnum"
                                    name="accessnum">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="callnum">Call Number</span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="...." 
                                    aria-label="Accession Number" 
                                    aria-describedby="basic-addon1"
                                    id="callnum"
                                    name="callnum">
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-12">
                            <div class="input-group">
                                <span class="input-group-text">Title</span>
                                <textarea class="form-control" 
                                    aria-label="With textarea"
                                    id="title"
                                    name="title">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col col-6">
                            <div class="input-group">
                                <select 
                                    class="form-select" 
                                    id="publisher"
                                    name="publisher" 
                                    aria-label="Publisher selection">
                                    <option selected>Choose Publisher..</option>
                                    <?php foreach($publishers as $publisher):?>
                                        <option value="<?php echo htmlspecialchars($publisher['id']);?>">
                                            <?php echo htmlspecialchars($publisher['publisherName']);?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <button 
                                    class="btn btn-outline-secondary" 
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#newPublisher">
                                        Add Publisher
                                </button>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="input-group">
                                <select 
                                    class="form-select" 
                                    id="author"
                                    name="author" 
                                    aria-label="Author selection">
                                    <option selected>Choose Authors..</option>
                                    <?php foreach($authors as $author):?>
                                        <option value="<?php echo htmlspecialchars($author['id']);?>">
                                            <?php echo htmlspecialchars($author['authorName']);?>
                                        </option>
                                    <?php endforeach;?>
                                </select>
                                <button class="btn btn-outline-secondary" type="button">Add Author</button>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="acnum">Copyright</span>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="199x" 
                                    aria-label="Accession Number" 
                                    aria-describedby="basic-addon1"
                                    id="copyright"
                                    name="copyright">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="accessnum">Copy</span>
                                <input 
                                    type="text" 
                                    class="form-control"  
                                    aria-label="Accession Number" 
                                    aria-describedby="basic-addon1"
                                    id="copy"
                                    name="copy"
                                    value="1"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col col-12">
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="bookCover">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </form>
</div>


<!-- Modal for Adding new publisher -->
<?php include '../balayanlms/book/addNewPublisher.php'; ?>

