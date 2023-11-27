<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_POST['submit'])){
        $id = htmlspecialchars($_POST['id']);
        $firstname = htmlspecialchars($_POST['first_name']);
        $lastname = htmlspecialchars($_POST['last_name']);
        $employeeNum = htmlspecialchars($_POST['employeeNum']);

        $stmt = $pdo->prepare("UPDATE faculty INNER JOIN user 
        ON faculty.user_id = user.id
        SET user.first_name = :first_name,
        user.last_name = :last_name,
        faculty.employee_num = :employeeNum
        WHERE faculty.id = :id");
        $stmt->bindParam(':first_name', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':employeeNum', $employeeNum, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'The information of faculty has been updated';
            header("Location:view_faculty.php?id=".$id);
            exit();
        }else{
            $_SESSION['status'] = 'error';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Error';
            $_SESSION['statusText'] = 'An error occured during operation. ';
        }
    }
    function getFaculty($pdo, $id){
        $stmt =$pdo->prepare("SELECT faculty.id,
        user.first_name,
        user.last_name,
        faculty.employee_num
        FROM faculty
        JOIN user ON faculty.user_id = user.id
        WHERE faculty.id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        return $student;
    }
    $faculty = getFaculty($pdo, $id);
?>
<?php require '../balayanlms/template/header.php';?>
    <?php if($faculty):?>
        <section class="card my-4 mx-auto w-75">
            <div class="row">
                <div class="col-4 border-end border-dark-subtle">
                    <div class="row">
                        <di class="col-12 px-5 py-4">
                            <img src="../balayanlms/assets/male.svg" class="img-fluid" alt="no result" width="250px">
                        </di>
                        <div class="col-12 px-5 py-3">
                            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" id="edit_form">
                                <p class="text-center mt-3 fs-5 fw-bold">Faculty's Information 
                                    <i class="bi-pencil-square text-danger" onclick="enableEdit()" style="cursor: pointer;"></i>
                                </p>
                                <div class="mb-3">
                                    <label for="srcode" class="form-label text-secondary fw-bold">Employee Number</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="employeeNum"
                                        name="employeeNum" 
                                        value="<?php echo htmlspecialchars($faculty['employee_num'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label text-secondary fw-bold">First Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="first_name" 
                                        name="first_name"
                                        value="<?php echo htmlspecialchars($faculty['first_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="last_name" class="form-label text-secondary fw-bold">Last Name</label>
                                    <input type="text" 
                                        class="form-control" 
                                        id="last_name"
                                        name="last_name" 
                                        value="<?php echo htmlspecialchars($faculty['last_name'])?>"
                                        disabled>
                                        <span class="text-danger"></span>
                                </div>
                                <div class="buttons d-none my-3">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($faculty['id']);?>">
                                    <button type="submit" class="btn btn-danger" name="submit" id="submitBtn">Update</button>
                                    <button type="button" class="btn btn-secondary" onclick="disableEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-8 p-4">
                    <div class="d-flex justify-content-end">
                        <a href="facultyDashboard.php" class="btn btn-danger">Back</a>
                    </div>
                    <h3 class="display-5 text-center mb-5">Faculty's History</h3>
                    <p class="fs-4 mb-0 text-center">No history for this faculty</p>
                    <div class="d-flex justify-content-center">
                        <img src="../balayanlms/assets/web_search.svg" class="img-fluid" alt="no result" width="330px">
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
<?php require '../balayanlms/template/footer.php';?>
        <script>
            const inputs = document.querySelectorAll('.form-control');
            const buttons = document.querySelector('.buttons');

            const enableEdit = () =>{
                buttons.classList.remove("d-none");
                inputs.forEach(input =>{
                    input.disabled = false;
                    
                });
            }

            const disableEdit = () =>{
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

            const validate = () =>{
                const employeeNum = inputs[0];
                const firstName = inputs[1];
                const lastName = inputs[2];

                if(isEmpty(employeeNum)){
                    setError(employeeNum, 'Please provide an employee number');
                    return false;
                }else{
                    setSuccess(employeeNum);
                }
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
</body>
</html>