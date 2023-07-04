<!-- Add Book  modal -->
<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="addBook" tabindex="-1" aria-labelledby="addBook" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addForm" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add new book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3">
                    <div class="input-group my-3">
                        <span class="input-group-text" id="basic-addon1">Call Number</span>
                        <input type="text" id="callnum" class="form-control" placeholder="Call Number" aria-label="Call Number" aria-describedby="basic-addon1" required>
                        <div class="invalid-feedback">
                            Please provide a <b>call number</b>.
                        </div>
                    </div>
                    <div class="input-group my-3">
                        <span class="input-group-text" id="basic-addon1">Title</span>
                        <input type="text" id="title" class="form-control" placeholder="Title" aria-label="Title" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="row my-3">
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Publisher</span>
                                <input type="text" id="publisher" class="form-control" placeholder="Publisher" aria-label="Publisher" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">
                                    Please provide a <b>title</b>.
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Author</span>
                                <input type="text" id="author" class="form-control" placeholder="Author" aria-label="Author" aria-describedby="basic-addon1" required>
                                <div class="invalid-feedback">
                                    Please provide an <b>author</b>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Copyright Year</span>
                                <input type="text" id="copyright" class="form-control" placeholder="199x" aria-label="copyright" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="invalid-feedback">
                                Please provide a <b>copyright year</b>.
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Copy</span>
                                <input type="text" class="form-control" value="1" aria-label="copy" aria-describedby="basic-addon1" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="input-group my-3">
                        <input type="file" class="form-control" id="bookCover" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        <button class="btn btn-outline-secondary" type="button" id="bookCoverUpload">Button</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" onsubmit="insertBook()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>