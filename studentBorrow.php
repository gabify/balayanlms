<?php
    
    function getStudent($pdo, $id){
        $stmt =$pdo->prepare("SELECT student.id,
        user.first_name,
        user.last_name,
        student.srcode,
        student.program,
        student.course,
        student.borrowed_books FROM student
        JOIN user ON student.user_id = user.id
        WHERE student.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }

    $student= getStudent($pdo, $id);
    
?>
<section class="card mb-1 px-4 py-3">
    <h5 class="fw-bold text-center">Borrower's Information</h5>
    <div>
        <p class="mb-0">
            <span class="fw-bold me-3">Sr-Code: </span>
            <span><?php echo $student['srcode'];?></span>
        </p>
        <p class="mb-0">
            <span class="fw-bold me-3">First Name: </span>
            <span><?php echo $student['first_name'];?></span>
        </p>
        <p>
            <span class="fw-bold me-3">Last Name: </span>
            <span><?php echo $student['last_name'];?></span>
        </p>
    </div>
</section>

<!--Will Add Pagination and search function later-->


<section class="px-4 py-3 card">
    <table class="table table-bordered table-hover">
        <thead class="table-danger">
            <tr class="text-center">
                <th scope="col">Call Number</th>
                <th scope="col">Title</th>
                <th scope="col">Copyright Year</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($books as $book):?>
                <tr class="text-center">
                    <td><?php echo $book['callnum']?></td>
                    <td><?php echo $book['title']?></td>
                    <td><?php echo $book['copyright']?></td>
                    <td>
                        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
                            <input type="hidden" id="bookId" name="bookId" value="<?php echo $book['id']?>">
                            <input type="hidden" id="studentId" name="studentId" value="<?php echo $student['id']?>">
                            <?php if($student['borrowed_books'] < 5):?>
                                <button class="btn btn-danger" type="submit" name="borrow">Borrow</button>
                            <?php else:?>
                                <button class="btn btn-danger" type="submit" name="borrow" disabled>Borrow</button>
                            <?php endif;?>
                        </form>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <!--Paginatiooonnnnn--->
    
    <div class="d-flex justify-content-end">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if($page_num == 1):?>
                    <li class="page-item disabled">
                        <a class="page-link text-dark">Previous</a>
                    </li>
                <?php else:?>
                    <li class="page-item">
                        <a class="page-link text-dark" 
                        href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $prev;?>">Previous</a>
                    </li>
                <?php endif;?>
                <?php if($totalPage <= 10):?>
                    <?php for($counter = 1; $counter <= $totalPage; $counter++):?>
                        <?php if($counter == $page_num):?>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link"><?php echo $counter;?></a>
                            </li>
                        <?php else:?>
                            <li class="page-item">
                                <a class="page-link text-dark" 
                                href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $counter;?>"><?php echo $counter;?></a>
                            </li>
                        <?php endif;?>
                    <?php endfor;?>
                <?php elseif($totalPage > 10):?>
                    <?php if($page_num < 4):?>
                        <?php for($counter = 1; $counter < 8; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link"><?php echo $counter;?></a>
                                </li>
                            <?php else:?>
                                <li class="page-item">
                                    <a class="page-link text-dark" 
                                    href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $counter;?>"><?php echo $counter;?></a>
                                </li>
                            <?php endif;?>
                        <?php endfor;?>
                        <li class="page-item" aria-current="page">
                            <a class="page-link text-dark">.....</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $secondLast;?>"><?php echo $secondLast;?></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $totalPage;?>"><?php echo $totalPage;?></a>
                        </li>
                    <?php elseif($page_num > 4 && $page_num < $totalPage - 4):?>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=2">2</a>
                        </li>
                        <li class="page-item" aria-current="page">
                            <a class="page-link text-dark">.....</a>
                        </li>
                        <?php for($counter = $page_num - $adjacents; $counter <= $page_num + $adjacents; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link"><?php echo $counter;?></a>
                                </li>
                            <?php else:?>
                                <li class="page-item">
                                    <a class="page-link text-dark" 
                                    href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $counter;?>"><?php echo $counter;?></a>
                                </li>
                            <?php endif;?>
                        <?php endfor;?>
                        <li class="page-item" aria-current="page">
                            <a class="page-link text-dark">.....</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $secondLast;?>"><?php echo $secondLast;?></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $totalPage;?>"><?php echo $totalPage;?></a>
                        </li>
                    <?php else:?>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link text-dark" 
                            href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=2">2</a>
                        </li>
                        <li class="page-item" aria-current="page">
                            <a class="page-link text-dark">.....</a>
                        </li>
                        <?php for($counter = $totalPage - 6; $counter <= $totalPage; $counter++):?>
                            <?php if($counter == $page_num):?>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link"><?php echo $counter;?></a>
                                </li>
                            <?php else:?>
                                <li class="page-item">
                                    <a class="page-link text-dark" 
                                    href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $counter;?>"><?php echo $counter;?></a>
                                </li>
                            <?php endif;?>
                        <?php endfor;?>
                    <?php endif;?>
                <?php endif;?>
                <?php if($page_num == $totalPage):?>
                    <li class="page-item disabled">
                        <a class="page-link text-dark">Next</a>
                    </li>
                <?php else:?>
                    <li class="page-item">
                        <a class="page-link text-dark" 
                        href="?user_type=<?php echo $userType;?>&id=<?php echo $id;?>&page-num=<?php echo $next;?>">Next</a>
                    </li>
                <?php endif;?>
            </ul>
        </nav>
    </div>
</section>