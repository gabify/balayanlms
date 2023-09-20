<?php
    if(!isset($_SESSION)){
        session_start();
    }
    date_default_timezone_set("Asia/Manila");
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    function getLog($pdo, $date){
        $stmt = $pdo->prepare("SELECT student_log.date_in,
        student.srcode,
        user.last_name,
        user.first_name,
        student.program,
        student_log.time_in,
        student_log.time_out
        FROM student_log JOIN student
        ON student_log.student_id = student.id
        JOIN user ON user.id = student.user_id
        WHERE date_in = :logDate
        ORDER BY time_in DESC");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $logs;
    }

    function getTotalLogs($pdo, $date){
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM student_log
        WHERE date_in = :logDate");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

    function getTotalCITlogs($pdo, $date){
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM student_log
        JOIN student ON student.id = student_log.student_id
        WHERE program = 'CIT' AND date_in = :logDate");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

    function getTotalCICSlogs($pdo, $date){
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM student_log
        JOIN student ON student.id = student_log.student_id
        WHERE program = 'CICS' AND date_in = :logDate");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

    function getTotalCTElogs($pdo, $date){
        $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM student_log
        JOIN student ON student.id = student_log.student_id
        WHERE program = 'CTE' AND date_in = :logDate");
        $stmt->bindParam(':logDate',  $date, PDO::PARAM_STR);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        return $total['total'];
    }

    $today = date('Y').'-'. date('m'). '-'. date('d');
    $logDate = $today;
    if(isset($_GET['submit'])){
        $logDate = htmlspecialchars($_GET['log']);
    }
    $logs = getLog($pdo, $logDate);
?>
<?php require '../balayanlms/template/header.php';?>
    <section class="card my-3 mx-3 p-3">
        <div class="d-flex justify-content-between">
            <h1 class="display-5">Student Logs</h1>
            <div class="d-flex justify-content-start my-2">
                <form id="logDatePicker" method="GET">
                    <div class="input-group mt-2">
                        <input type="date" name="log" id="log" value="<?php echo $logDate;?>" class="bg-danger fw-light">
                        <button type="submit" name="submit" class=" btn btn-outline-danger">Go to</button>
                    </div>
                </form>
                <a href="../balayanlms/student-log.php?log=<?php echo $today?>"
                    class="btn btn-outline-danger mx-2 mt-2">
                    Today
                </a>
                <?php if($logs):?>
                    <a href="../balayanlms/student/export_student.php?log=<?php echo $logDate;?>" 
                    class="btn btn-danger mt-2">
                        <i class="bi-download"></i>
                        Export
                    </a>
                <?php else:?>
                    <button class="btn btn-danger mt-2" disabled>
                        <i class="bi-download"></i>
                        Export
                    </button>
                <?php endif;?>
            </div>
        </div>
    </section>
    <section class="card my-3 mx-3 p-3">
        <div class="row summary my-3">
        <div class="col-3">
                <div class="card">
                    <div class="card-body text-bg-success rounded-2">
                        <i class="bi-person-circle float-end fs-1"></i>
                        <h3 class="card-title display-5 fw-bold">
                            <?php echo htmlspecialchars(getTotalLogs($pdo, $logDate))?>
                        </h3>
                        <p class="card-text fs-5 ms-1 fw-light">Total Logs</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-bg-danger rounded-2">
                        <i class="bi-person-circle float-end fs-1"></i>
                        <h3 class="card-title display-5 fw-bold">
                            <?php echo htmlspecialchars(getTotalCITlogs($pdo, $logDate))?>
                        </h3>
                        <p class="card-text fs-5 ms-1 fw-light">CIT</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-bg-primary rounded-2">
                        <i class="bi-person-circle float-end fs-1"></i>
                        <h3 class="card-title display-5 fw-bold">
                            <?php echo htmlspecialchars(getTotalCICSlogs($pdo, $logDate))?>
                        </h3>
                        <p class="card-text fs-5 ms-1 fw-light">CICS</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-bg-warning rounded-2">
                        <i class="bi-person-circle float-end fs-1"></i>
                        <h3 class="card-title display-5 fw-bold">
                            <?php echo htmlspecialchars(getTotalCTElogs($pdo, $logDate))?>
                        </h3>
                        <p class="card-text fs-5 ms-1">CTE</p>
                    </div>
                </div>
            </div>
        </div>
        <?php if($logs):?>
            <table class="table table-bordered">
                <thead class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Srcode</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Program</th>
                    <th scope="col">Time In</th>
                    <th scope="col">Time Out</th>
                </thead>
                <tbody class="text-center">
                    <?php $i = 1;?>
                    <?php foreach($logs as $log):?>
                        <tr>
                            <th scope="row"><?php echo $i++;?></th>
                            <td><?php echo htmlspecialchars($log['date_in']);?></td>
                            <td><?php echo htmlspecialchars($log['srcode']);?></td>
                            <td><?php echo htmlspecialchars($log['last_name']);?></td>
                            <td><?php echo htmlspecialchars($log['first_name']);?></td>
                            <td><?php echo htmlspecialchars($log['program']);?></td>
                            <td><?php echo htmlspecialchars($log['time_in']);?></td>
                            <td><?php echo htmlspecialchars($log['time_out']);?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        <?php else:?>
            <p class="display-3 text-center my-5">No such log exist.</p>
            <div class="d-flex justify-content-center p-5">
                <img src="../balayanlms/assets/web_search.svg" alt="no result" class="img-fluid w-50">
            </div>
        <?php endif;?>
    </section>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>