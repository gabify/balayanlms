<div 
    class="tab-pane fade show active py-3" 
    id="tableViewContent" role="tabpanel" 
    aria-labelledby="home-tab" 
    tabindex="0">
        <?php if($page_no > $totalPages):?>
            <h1 class="text-center display-3 py-5">No Result Found</h1>
        <?php else:?>
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
                    <tr class="text-center" id="<?php echo htmlspecialchars($book['id']);?>">
                        <th scope="row"><?php echo htmlspecialchars($book['accessnum']);?></th>
                        <td><?php echo htmlspecialchars($book['callnum']);?></td>
                        <td class="w-50"><?php echo htmlspecialchars($book['title']);?></td>
                        <td>
                            <a class="btn" href="viewBook.php?id=<?php echo htmlspecialchars($book['id']);?>">
                                <i class="bi-eye-fill fs-4 text-primary"></i>
                            </a>
                            <a href="editBook.php?id=<?php echo htmlspecialchars($book['id']);?>" class="btn">
                                <i class="bi-pencil-fill fs-4 text-warning"></i>
                            </a>
                            <button 
                                class="btn"
                                onclick="deleteBook(<?php echo htmlspecialchars($book['id']);?>)">
                                <i class="bi-trash3-fill fs-4 text-danger"></i>
                            </button>
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
                            Showing <?php echo $page_no;?> out of <?php echo $totalPages;?> entries
                        </div>
                    </div>
                    <div class="col col-7">
                        <nav aria-label="Table Pagination">
                            <ul class="pagination justify-content-end">
                                <?php if($page_no <= 1):?> <!--For previous page link-->
                                    <li class="page-item <?php if($page_no <= 1){echo 'disabled';}?>">
                                        <a class="page-link text-dark" href="#">Previous</a>
                                    </li>
                                <?php else:?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="?page_no=<?php echo $page_no-1;?>">Previous</a>
                                    </li>
                                <?php endif;?>
                                <?php if($totalPages <= 10):?> <!-- If pages are less than 10 -->
                                    <?php for($counter = 1; $counter <= $totalPages; $counter++):?>
                                        <?php if($counter == $page_no):?>
                                            <li class="page-item active">
                                                <a class="page-link"><?php echo $counter;?></a>
                                            </li>
                                        <?php else:?>
                                            <li class="page-item">
                                                <a class="page-link text-dark" href="<?php echo '?page_no='.$counter;?>"><?php echo $counter;?></a>
                                            </li>
                                        <?php endif;?>
                                    <?php endfor;?>
                                <?php elseif($totalPages > 10):?> <!-- if pages are greater than 10 -->
                                    <?php if($page_no <= 4):?>
                                        <?php for($counter = 1; $counter < 8; $counter++):?>
                                            <?php if($counter == $page_no):?>
                                                <li class="page-item active">
                                                    <a class="page-link"><?php echo $counter;?></a>
                                                </li>
                                            <?php else:?>
                                                <li class="page-item">
                                                    <a class="page-link text-dark" href="<?php echo '?page_no='.$counter;?>"><?php echo $counter;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endfor;?>
                                        <li class="page-item">
                                            <a class="page-link text-dark">...</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="<?php echo '?page_no='.$totalPages-1;?>"><?php echo $totalPages-1;?></a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="<?php echo '?page_no='.$totalPages;?>"><?php echo $totalPages;?></a>
                                        </li>
                                    <?php elseif($page_no > 4 && $page_no < $totalPages - 4):?>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="?page_no=1">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="?page_no=2">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark">...</a>
                                        </li>
                                        <?php for($counter = $page_no -2; $counter <= $page_no + 2; $counter++):?>
                                            <?php if($counter == $page_no):?>
                                                <li class="page-item active">
                                                    <a class="page-link"><?php echo $counter;?></a>
                                                </li>
                                            <?php else:?>
                                                <li class="page-item">
                                                    <a class="page-link text-dark" href="<?php echo '?page_no='.$counter;?>"><?php echo $counter;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endfor;?>
                                        <li class="page-item">
                                            <a class="page-link text-dark">...</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="<?php echo '?page_no='.$totalPages-1;?>"><?php echo $totalPages-1;?></a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="<?php echo '?page_no='.$totalPages;?>"><?php echo $totalPages;?></a>
                                        </li>
                                    <?php else:?>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="?page_no=1">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark" href="?page_no=2">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link text-dark">...</a>
                                        </li>
                                        <?php for($counter = $totalPages -6; $counter <= $totalPages; $counter++):?>
                                            <?php if($counter == $page_no):?>
                                                <li class="page-item active">
                                                    <a class="page-link"><?php echo $counter;?></a>
                                                </li>
                                            <?php else:?>
                                                <li class="page-item">
                                                    <a class="page-link text-dark" href="<?php echo '?page_no='.$counter;?>"><?php echo $counter;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endfor;?>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if($page_no >= $totalPages):?>
                                    <li class="page-item disabled">
                                        <a class="page-link text-dark" href="#">Next</a>
                                    </li>
                                <?php else:?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="?page_no=<?php echo $page_no+1;?>">Next</a>
                                    </li>
                                <?php endif;?>
                                <?php if($page_no >= $totalPages):?>
                                    <li class="page-item disabled">
                                        <a class="page-link text-dark" href="#">Last &raquo;</a>
                                    </li>
                                <?php else:?>
                                    <li class="page-item">
                                        <a class="page-link text-dark" href="?page_no=<?php echo $totalPages;?>">Last &raquo;</a>
                                    </li>
                                <?php endif;?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>

