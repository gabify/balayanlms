<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    $studentInfo = array("id"=>"", "first_name"=>"last_name", "srcode"=>"", "program"=>"");
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_POST['submit'])){
        $studentInfo['id'] = htmlspecialchars($_POST['id']);
        $studentInfo['srcode'] = htmlspecialchars($_POST['srcode']);
        $studentInfo['first_name'] = htmlspecialchars($_POST['first_name']);
        $studentInfo['last_name'] = htmlspecialchars($_POST['last_name']);
        $studentInfo['program'] = htmlspecialchars($_POST['program']);
       updateStudent($pdo, $studentInfo);
    }
    function updateStudent($pdo, $student){
        $stmt = $pdo->prepare("UPDATE student INNER JOIN user 
        ON student.user_id = user.id
        SET user.first_name = :first_name,
        user.last_name = :last_name,
        student.srcode = :srcode,
        student.program = :program
        WHERE student.id = :id");
        $stmt->bindParam(':first_name', $student['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $student['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':srcode', $student['srcode'], PDO::PARAM_STR);
        $stmt->bindParam(':program', $student['program'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $student['id'], PDO::PARAM_INT);
        if($stmt->execute()){
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'The information of student has been updated';
            header("Location:view_student.php?id=".$student['id']);
            exit();
        }else{
            $_SESSION['status'] = 'error';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Error';
            $_SESSION['statusText'] = 'An error occured during operation. ';
        }
    }

    function getStudent($pdo, $id){
        $stmt =$pdo->prepare("SELECT student.id,
        user.first_name,
        user.last_name,
        student.srcode,
        student.program FROM student
        JOIN user ON student.user_id = user.id
        WHERE student.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }
    $student= getStudent($pdo, $id);
?>
<?php require '../balayanlms/template/header.php';?>
    <?php if($student):?>
        <section class="card m-4 bg-light">
            <div class="row">
                <div class="col-3 border-end border-dark-subtle">
                    <div class="row">
                        <di class="col-12 px-5 py-4">
                            <img src="../balayanlms/assets/male.svg" class="img-fluid" alt="no result" width="250px">
                        </di>
                        <div class="col-12 px-5 py-3">
                            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" id="edit_form">
                                <p class="text-center mt-3 fs-5 fw-bold">Student's Information 
                                    <i class="bi-pencil-square text-danger" onclick="enableEdit()" style="cursor: pointer;"></i>
                                </p>
                                <div class="mb-3">
                                    <label for="srcode" class="form-label text-secondary fw-bold">Srcode</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="srcode"
                                        name="srcode" 
                                        value="<?php echo htmlspecialchars($student['srcode'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label text-secondary fw-bold">First Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="first_name" 
                                        name="first_name"
                                        value="<?php echo htmlspecialchars($student['first_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label text-secondary fw-bold">Last Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="last_name"
                                        name="last_name" 
                                        value="<?php echo htmlspecialchars($student['last_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="program" class="form-label text-secondary fw-bold">Program</label>
                                    <select class="form-select" aria-label="program" id="program" name="program" disabled>
                                        <?php if($student['program'] == 'CICS'):?>
                                            <option value="CICS" selected>CICS</option>
                                        <?php else:?>
                                            <option value="CICS">CICS</option>
                                        <?php endif;?>
                                        <?php if($student['program'] == 'BIT'):?>
                                            <option value="BIT" selected>BIT</option>
                                        <?php else:?>
                                            <option value="BIT">BIT</option>
                                        <?php endif;?>
                                        <?php if($student['program'] == 'CTE'):?>
                                            <option value="CTE" selected>CTE</option>
                                        <?php else:?>
                                            <option value="CTE">CTE</option>
                                        <?php endif;?>
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="buttons d-none my-3">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']);?>">
                                    <button type="submit" class="btn btn-danger" name="submit" id="submitBtn">Update</button>
                                    <button type="button" class="btn btn-secondary" onclick="disableEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-9 p-4">
                    <h3 class="display-5 text-center mb-5">Student's History</h3>
                    <p class="fs-4 mb-0 text-center">No history for this student</p>
                    <div class="d-flex justify-content-center">
                        <img src="../balayanlms/assets/web_search.svg" class="img-fluid" alt="no result" width="500px">
                    </div>
                </div>
            </div>
        </section>
    <?php else:?>
        <div class="m-3 p3">
            <h3 class="display-5 text-center my-3">No such student exist.</h3>
            <div class="d-flex justify-content-center">
                <img src="../balayanlms/assets/web_search.svg" class="img-fluid w-50" alt="no result">
            </div>
        </div>
    <?php endif;?>
    <script>
        const inputs = document.querySelectorAll('.form-control');
        const currentSrcode = inputs[0].value.trim();
        const program = document.querySelector('.form-select');
        const buttons = document.querySelector('.buttons');
        const submit = document.querySelector('#submitBtn');

        const enableEdit = () =>{
            program.disabled = false;
            buttons.classList.remove("d-none");
            inputs.forEach(input =>{
                input.disabled = false;
                
            });
        }

        const disableEdit = () =>{
            program.disabled = true;
            buttons.classList.add("d-none");
            inputs.forEach(input =>{
                input.disabled = true;
                
            });
        }

        const setError = (element, message) =>{
            const errorMessage = element.nextElementSibling;
            const label = element.previousElementSibling;

            errorMessage.innerText = message;
            label.classList.add("text-danger");
            element.classList.add("border-danger");
        }
        const setSuccess = (element) =>{
            const errorMessage = element.nextElementSibling;
            const label = element.previousElementSibling;

            errorMessage.innerText = "";
            label.classList.remove("text-danger");
            element.classList.remove("border-danger");
        }

        const isEmpty = (element) => {
            if(element.value === ''){
                return true;
            }
            return false;
        }

        const isValid = (srcode) =>{
            const regex = /^[\d]{2}-[\d]{5}$/
            return regex.test(srcode.value);
        }

        const isRegistered = async(srcode) =>{
            const response = await fetch('../lms-student-portal/function/validateSrcode.php?srcode='+srcode.value);
            const result = await response.text()
            return result;
        }

        inputs[0].addEventListener('input', e =>{
            const val = e.target
            if(isEmpty(val)){
                setError(val, 'Please provide an srcode');
                submit.disabled = true;
            }else{
                if(isValid(val)){
                    if(val.value === currentSrcode){
                        setSuccess(e.target);
                        submit.disabled = false;
                    }else{
                        isRegistered(val)
                        .then(result =>{
                            if(result === 'registered'){
                                setError(val, 'The srcode is already registered.');
                                submit.disabled = true; 
                            }else{
                                submit.disabled = false;
                            }
                        }).catch(err =>{
                            console.log(err);
                        });
                    }
                }else{
                    setError(val, 'Please provide a valid srcode');
                    submit.disabled = true;
                }
            }
        })

        const validate = () =>{
            const firstName = inputs[1];
            const lastName = inputs[2];

            if(isEmpty(firstName)){
                setError(firstName, 'Please provide a first name');
                return false;
            }else{
                setSuccess(firstName);
            }
            if(isEmpty(lastName)){
                setError(lastName, 'Please provide a last name');
                return false;
            }else{
                setSuccess(lastName);
            }
            return true;
        }

        const form = document.querySelector('#edit_form');
        form.addEventListener('submit', e =>{
            if(!validate()){
                e.preventDefault();
                e.stopPropagation();
            }
        });
    </script>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>