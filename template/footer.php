        <footer class="bg-danger text-light py-3 px-4">
            <div class="my-3 border-bottom pb-2">
                <div class="d-flex justify-content-between">
                    <h4 class="fw-bold">Library Management System</h4>
                    <ul class="nav">
                        <li class=" footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" aria-current="page" href="../balayanlms/index.php">
                                <i class="bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/bookDashboard.php">
                                <i class="bi-journal-bookmark-fill"></i>
                                Books
                            </a>
                        </li>
                        <li class="footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/thesisDashboard.php">
                                <i class="bi-journal-bookmark"></i>
                                Theses
                            </a>
                        </li>
                        <li class="footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/facultyDashboard.php">
                                <i class="bi-mortarboard-fill"></i>
                                Faculty
                            </a>
                        </li>
                        <li class="footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/studentDashboard.php">
                                <i class="bi-person-circle"></i>
                                Students
                            </a>
                        </li>
                        <li class="footer-link nav-item">
                            <a class="nav-link fs-5 fw-light text-light" href="../balayanlms/student-log.php">
                                <i class="bi-person-lines-fill"></i>
                                Student Logs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            Copyright &copy;2023 <a href="https://gabify.github.io/" class="text-decoration-none text-dark">Gabify&#128020</a>
        </footer>
        <script src="../balayanlms/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../balayanlms/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../balayanlms/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>

        <?php if(isset($_SESSION['status'])):?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['statusIcon'];?>',
                    title: '<b><?php echo $_SESSION['statusTitle'];?></b>',
                    text: '<?php echo $_SESSION['statusText'];?>'
                })
            </script>
            <?php 
                unset($_SESSION['status']);
                unset($_SESSION['statusIcon']);
                unset($_SESSION['statusTitle']);
                unset($_SESSION['statusText']);
            ?>
        <?php endif;?>