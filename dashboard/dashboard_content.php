<?php 
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    date_default_timezone_set('Asia/Manila');

    function getAllBooks($pdo){
        $stmt = $pdo->query("SELECT COUNT(id) AS allBooks FROM books");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['allBooks'];
    }

    function getAllThesis($pdo){
        $stmt = $pdo->query("SELECT COUNT(id) AS allThesis FROM thesis");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['allThesis'];
    }

    function getAllStudents($pdo){
        $stmt = $pdo->query("SELECT COUNT(id) AS allStudent FROM student");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['allStudent'];
    }
    function getDataByStat($pdo, $status){
        $stmt = $pdo->prepare("SELECT COUNT(id) AS allBooks FROM books 
        WHERE status = :stat");
        $stmt->bindParam(':stat', $status, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['allBooks'];
    }

    function getTotalLogs($pdo, $today){
        $stmt= $pdo->prepare('SELECT COUNT(id) AS totalLogs FROM student_log
        WHERE date_in = :today');
        $stmt->bindParam('today', $today, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalLogs'];
    }

    function getCITLogs($pdo, $today, $program){
        $stmt= $pdo->prepare("SELECT COUNT(student_log.id) AS logs FROM student_log
        JOIN student ON student_log.student_id = student.id WHERE date_in = :today
        AND program = :program");
        $stmt->bindParam(':today', $today, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['logs'];
    }

?>

<div class="container pt-4">
    <div class="row">
        <div class="col-4">
            <div class="card border-0" id="books">
                <div class="card-body">
                    <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getAllBooks($pdo);?></h5>
                    <p class="card-text text-light pt-1 fw-light">Total Books</p>
                </div>
                <a href="../balayanlms/bookDashboard.php" class="text-decoration-none">
                    <div class="card-footer text-center text-light">
                        More
                        <i class="bi-arrow-right-circle"></i>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="col-4">
            <div class="card border-0" id="theses">
                <div class="card-body">
                    <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getAllThesis($pdo);?></h5>
                    <p class="card-text text-light pt-1 fw-light">Total Theses</p>
                </div>
                <a href="../balayanlms/thesisDashboard.php" class="text-decoration-none">
                    <div class="card-footer text-center text-light">
                        More
                        <i class="bi-arrow-right-circle"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-4">
            <div class="card border-0" id="students">
                <div class="card-body">
                    <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getAllStudents($pdo);?></h5>
                    <p class="card-text text-light pt-1 fw-light">Total Students</p>
                </div>
                <a href="../balayanlms/studentDashboard.php" class="text-decoration-none">
                    <div class="card-footer text-center text-light">
                        More
                        <i class="bi-arrow-right-circle"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container my-5 rounded-5 py-3" id="visitsGraph" style="box-shadow: 0 4px 12px -2px rgba(0,0,0,0.3);">
    <div class="px-5 py-3">
        <div class="row">
            <div class="col-8">
                <canvas class="visits mb-3"></canvas>
            </div>
            <div class="col-4">
                <div class="card text-bg-secondary border-0 mb-2">
                    <div class="card-body">
                        <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getTotalLogs($pdo, date("Y-m-d"));?></h5>
                        <p class="card-text text-light pt-1 fw-light">Total Logs</p>
                    </div>
                </div>
                <div class="card text-bg-danger border-0 mb-2">
                    <div class="card-body">
                        <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getCITLogs($pdo, date("Y-m-d"), "CIT");?></h5>
                        <p class="card-text text-light pt-1 fw-light">CIT Students</p>
                    </div>
                </div>
                <div class="card border-0 mb-2 text-bg-primary">
                    <div class="card-body">
                        <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getCITLogs($pdo, date("Y-m-d"), "CICS");?></h5>
                        <p class="card-text text-light pt-1 fw-light">CICS Students</p>
                    </div>
                </div>
                <div class="card border-0 mb-2 text-bg-warning">
                    <div class="card-body">
                        <h5 class="card-title text-light pt-2 fs-4 fw-bolder"><?php echo getCITLogs($pdo, date("Y-m-d"), "CTE");?></h5>
                        <p class="card-text text-light pt-1 fw-light">CTE Students</p>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-end">
            <a href="student-log.php" 
                class="text-danger link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0">
                    <small>
                        Manage Student log
                        <i class="bi bi-arrow-right-short"></i>
                    </small>
                    
            </a>
        </p>
    </div>
</div>

<div class="container my-5 rounded-5 py-3 px-5" id="charts" style="box-shadow: 0 4px 12px -2px rgba(0,0,0,0.3);">
    <h4 class="text-center">Book Status</h4>
    <div class="row">
        <div class="col col-xl-4 col-lg-6 col-sm-12">
            <div class="charts">
                <canvas class="book-chart"></canvas>
            </div>
        </div>
        <div class="col col-xl-8 col-lg-6 col-sm-12 px-5">
            <div class="d-flex justify-content-evenly mb-2 mt-5 pt-4">
                <div class="card text-bg-primary" style="width: 240px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo getDataByStat($pdo,"Available");?></h5>
                        <p class="card-text pt-1 fw-light">Available Books</p>
                    </div>
                </div>
                <div class="card text-bg-danger" style="width: 240px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo getDataByStat($pdo,"Borrowed");?></h5>
                        <p class="card-text pt-1 fw-light">Borrowed Books</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-evenly">
                <div class="card text-bg-warning" style="width: 240px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo getDataByStat($pdo,"Weeded-out");?></h5>
                        <p class="card-text pt-1 fw-light">Weeded-out Books</p>
                    </div>
                </div>
                <div class="card text-bg-success" style="width: 240px;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo getDataByStat($pdo,"Missing");?></h5>
                        <p class="card-text pt-1 fw-light">Missing Books</p>
                    </div>
                </div>
            </div>

            <p class="fs-6 fw-light mt-3 ms-5">Note: Numbers and chart do not update automatically.</p>
        </div>
        <p class="text-end">
            <a href="viewBook.php" 
                class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0">
                    <small>
                        Manage Books
                        <i class="bi bi-arrow-right-short"></i>
                    </small>
            </a>
        </p>
    </div>
    
</div>

<section class="container my-5 rounded-5 p-3" id="richTextEditor" style="box-shadow: 0 4px 12px -2px rgba(0,0,0,0.3);">
    <form action="setAnnouncement.php" method="POST">
        <div class="my-3 mx-auto" style="width: 700px;">
            <h4 class="text-center mb-4">Create New Announcement &#128227;</h4>
            <div class="border border-dark-subtle rounded-5 p-4">
                <div class="mb-3 mt-2">
                    <label for="title" class="form-label ms-3 fw-bold">Title</label>
                    <input type="text" name="title" class="form-control p-3 rounded-5" id="title" placeholder="Type the announcement here....">
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label ms-3 fw-bold">Body</label>
                    <textarea class="form-control p-4 rounded-5" name="body" placeholder="Provide a details here...." id="body" style="min-height: 300px;"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" name="save" class="btn btn-danger">Save</button>
                </div>
            </div>
        </div>
    </form>
</section>
