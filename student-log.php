<?php
    if(!isset($_SESSION)){
        session_start();
    }
    date_default_timezone_set("Asia/Manila");
    $months = ['',
                'January', 
                'February', 
                'March', 
                'April', 
                'May', 
                'June', 
                'July', 
                'August', 
                'September', 
                'October', 
                'November', 
                'December'];

    $currentMonth = date('m');
    $currentDay = date('d');
    $currentYear = date('Y');
    $now = $currentMonth. ' '. $currentDay. ', '. $currentYear;
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';

    function getLog($pdo, $date){
        $stmt = $pdo->prepare("SELECT student_log.date_in,
        student.srcode,
        user.last_name,
        user.first_name,
        student.program,
        student.course,
        student_log.time_in,
        student_log.time_out
        FROM student_log JOIN student
        ON student_log.student_id = student.id
        JOIN user ON user.id = student.user_id
        WHERE date_in = :logDate
        ORDER BY student_log.id DESC");
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
        $currentYear = htmlspecialchars($_GET['year']);
        $currentMonth = htmlspecialchars($_GET['month']);
        $currentDay = htmlspecialchars($_GET['day']);
        $logDate = $currentYear.'-'. $currentMonth. '-'. $currentDay;
    }
    $logs = getLog($pdo, $logDate);
?>
<?php require '../balayanlms/template/header.php';?>
<main class="w-75 mx-auto my-4">
    <section class="card mb-1 px-2" style="background-color: #E3E9F7;">
        <div class="card-body d-flex justify-content-between">
            <h3 class="fs-2 fw-light">Student Log</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="get" class="mt-1">
                <div class="d-flex justify-content-evenly">
                    <select class="form-select me-1" aria-label="month" name="month">
                        <?php for($i=0; $i< count($months); $i++):?>
                            <?php if($i == $currentMonth):?>
                                <option selected value="<?php echo $i?>"><?php echo $months[$i];?></option>
                            <?php else:?>
                                <option value="<?php echo $i?>"><?php echo $months[$i];?></option>
                            <?php endif;?>
                        <?php endfor;?>
                    </select>
                    <select class="form-select me-1" aria-label="day" name="day">
                        <?php for($i=1; $i< 32; $i++):?>
                            <?php if($i == $currentDay):?>
                                <option selected value="<?php echo $i?>"><?php echo $i;?></option>
                            <?php else:?>
                                <option value="<?php echo $i?>"><?php echo $i;?></option>
                            <?php endif;?>
                        <?php endfor;?>
                    </select>
                    <select class="form-select me-1" aria-label="year" name="year">
                        <?php for($i=2000; $i< 2200; $i++):?>
                            <?php if($i == $currentYear):?>
                                <option selected value="<?php echo $i?>"><?php echo $i;?></option>
                            <?php else:?>
                                <option value="<?php echo $i?>"><?php echo $i;?></option>
                            <?php endif;?>
                        <?php endfor;?>
                    </select>
                    <button class="btn btn-danger" type="submit" name="submit">Go</button>
                </div>
            </form>
        </div>
    </section>
    <section class="card px-2 py-3" style="background-color: #E3E9F7;">
        <div class="card-body">
            <!--Summary of logs-->
            <div class="row">
                <!--Total logs-->
                <div class="col">
                    <div class="card text-bg-secondary">
                        <div class="card-body">
                            <i class="bi-person-circle float-end fs-1"></i>
                            <h5 class="card-title">
                                <?php echo htmlspecialchars(getTotalLogs($pdo, $logDate))?>
                            </h5>
                            <p class="card-title">Total Logs</p>
                        </div>
                    </div>
                </div>
                <!--CIT Logs-->
                <div class="col">
                    <div class="card text-bg-danger">
                        <div class="card-body">
                            <i class="bi-person-circle float-end fs-1"></i>
                            <h5 class="card-title">
                                <?php echo htmlspecialchars(getTotalCITlogs($pdo, $logDate))?>
                            </h5>
                            <p class="card-title">CIT</p>
                        </div>
                    </div>
                </div>
                <!--CICS Logs-->
                <div class="col">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <i class="bi-person-circle float-end fs-1"></i>
                            <h5 class="card-title">
                                <?php echo htmlspecialchars(getTotalCICSlogs($pdo, $logDate))?>
                            </h5>
                            <p class="card-title">CICS</p>
                        </div>
                    </div>
                </div>
                <!--CTE Logs-->
                <div class="col">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <i class="bi-person-circle float-end fs-1"></i>
                            <h5 class="card-title">
                                <?php echo htmlspecialchars(getTotalCTElogs($pdo, $logDate))?>
                            </h5>
                            <p class="card-title">CTE</p>
                        </div>
                    </div>
                </div>
            </div>

            <!--Table of Logs-->
            <?php if($logs):?>
                <table class="table table-bordered table-hover mt-4 mb-3">
                    <thead class="table-danger">
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Srcode</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Program</th>
                            <th scope="col">Course</th>
                            <th scope="col">Time In</th>
                            <th scope="col">Time Out</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $i = 1;?>
                        <?php foreach($logs as $log):?>
                            <tr>
                                <th scope="row"><?php echo $i++;?></th>
                                <td><?php echo htmlspecialchars($log['srcode']);?></td>
                                <td><?php echo htmlspecialchars($log['last_name']);?></td>
                                <td><?php echo htmlspecialchars($log['first_name']);?></td>
                                <td><?php echo htmlspecialchars($log['program']);?></td>
                                <td><?php echo htmlspecialchars($log['course']);?></td>
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
            <div class="d-flex justify-content-end">
                <?php if($logs):?>
                    <a href="../balayanlms/student/export_student.php?log=<?php echo $logDate;?>" 
                    class="btn btn-danger me-2">
                        <i class="bi-download"></i>
                    </a>
                <?php else:?>
                    <button class="btn btn-danger me-2" disabled>
                        <i class="bi-download"></i>
                    </button>
                <?php endif;?>
                <a href="index.php" class="btn btn-outline-danger">Back</a>
            </div>
        </div>
    </section>
</main>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>