<?php 
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';


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

<div class="container pt-5" id="charts">
    <div class="row">
        <div class="col col-xl-4 col-lg-6 col-sm-12">
            <div class="charts">
                <canvas class="book-chart"></canvas>
            </div>
        </div>
        <div class="col col-xl-4 col-lg-6 col-sm-12">
            <div class="charts">
                <canvas class="thesis-chart"></canvas>
            </div>
        </div>
        <div class="col col-xl-4 col-lg-6 col-sm-12">
            <div class="charts">
                <canvas class="student-chart"></canvas>
            </div>
        </div>
    </div>
</div>
