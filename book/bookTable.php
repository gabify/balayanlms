<div class="mb-2 row">
    <div class="col-6">
        <div class="row">
            <div class="col-1 lead">Show</div>
            <div class="col-2">
                <select name="limit" id="limit" class="form-select">
                    <option value="10" selected>10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-1 lead">Books</div>
        </div>
    </div>
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