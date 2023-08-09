<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id= '';
    $thesisData = array("callnum"=>"", "author"=>"", "title"=>"", "adivser"=>"", "publicationYear"=>"");
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_POST['submit'])){
        $thesisData['id']= htmlspecialchars($_POST['id']);
        $thesisData['callnum']= htmlspecialchars($_POST['callnum']);
        $thesisData['author']= htmlspecialchars($_POST['author']);
        $thesisData['title']= htmlspecialchars($_POST['title']);
        $thesisData['adviser']= htmlspecialchars($_POST['adviser']);
        $thesisData['publicationYear']= htmlspecialchars($_POST['publicationYear']);

        $stmt= $pdo->prepare("UPDATE thesis SET callnum = :callnum,
        author = :author, title = :title, adviser = :adviser, publication_year = :publicationYear
        WHERE id = :id");
        $stmt->bindParam(':callnum', $thesisData['callnum'], PDO::PARAM_STR);
        $stmt->bindParam(':author', $thesisData['author'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $thesisData['title'], PDO::PARAM_STR);
        $stmt->bindParam(':adviser', $thesisData['adviser'], PDO::PARAM_STR);
        $stmt->bindParam(':publicationYear', $thesisData['publicationYear'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $thesisData['id'], PDO::PARAM_INT);
        if($stmt->execute()){
            $_SESSION['status'] = 'success';
            $_SESSION['statusIcon'] = 'success';
            $_SESSION['statusTitle'] = 'Operation successful';
            $_SESSION['statusText'] = 'The information of the thesis has been updated';
            header("Location:view_thesis.php?id=".$thesisData['id']);
            exit();
        }else{
            $_SESSION['status'] = 'error';
            $_SESSION['statusIcon'] = 'error';
            $_SESSION['statusTitle'] = 'Error';
            $_SESSION['statusText'] = 'An error occured during operation. ';
        }
    }

    function getThesis($pdo, $id){
        $stmt= $pdo->prepare("SELECT * FROM thesis WHERE id = :id AND is_deleted = 0");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $thesis = getThesis($pdo, $id);
?>
<?php require '../balayanlms/template/header.php';?>
    <main class="container-fluid p-5">
        <?php if($thesis):?>
            <div class="card p-2 m-4">
                <div class="card-body">
                    <h3 class="card-title text-center">
                        Thesis Information 
                        <button type="button" class="btn" onclick="enableEdit()"><i class="bi-pencil-square fs-5"></i></button>
                    </h3>
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="thesis-edit">
                        <div class="row mt-4">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3 mx-5">
                                    <label for="callnum" class="form-label text-secondary fw-bold">Call Number</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="callnum"
                                        name="callnum" 
                                        value="<?php echo htmlspecialchars($thesis['callnum'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="publisher" class="form-label text-secondary fw-bold">Adviser</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="adviser"
                                        name="adviser" 
                                        value="<?php echo htmlspecialchars($thesis['adviser'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="copyright" class="form-label text-secondary fw-bold">Publication Year</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="publicationYear"
                                        name="publicationYear" 
                                        value="<?php echo htmlspecialchars($thesis['publication_year'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="copy" class="form-label text-secondary fw-bold">Copy</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="copy"
                                        name="copy" 
                                        value="<?php echo htmlspecialchars($thesis['copy'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3 mx-5">
                                    <label for="title" class="form-label text-secondary fw-bold">Title</label>
                                    <textarea class="form-control ms-1"
                                     id="title"
                                     name="title"
                                     rows="3"
                                     disabled><?php echo htmlspecialchars(trim($thesis['title']))?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="author" class="form-label text-secondary fw-bold">Authors</label>
                                    <textarea class="form-control ms-1"
                                     id="author"
                                     name="author"
                                     rows="5"
                                     disabled
                                     ><?php foreach(explode(',', $thesis['author']) as $author):?><?php echo htmlspecialchars($author).',&#10;';?><?php endforeach;?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-12 my-3 d-none buttons">
                                <div class="d-flex justify-content-end">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($thesis['id']);?>">
                                    <button type="submit" class="btn btn-danger mx-1" name="submit" id="submitBtn">Update</button>
                                    <button type="button" class="btn btn-secondary mx-1" onclick="disableEdit()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php else:?>
            <div class="container-fluid text-center pt-4 pb-5">
                <i class="bi-emoji-frown sadFace"></i>
                <h1 id="error404">404</h1>
                <h4 class="fs-2 fw-bold mb-0">Not Found</h4>
                <p class="fw-light">The thesis requested could not be found on the server.</p>
            </div>
        <?php endif;?>
    </main>
<?php require '../balayanlms/template/footer.php';?>
    <script>
        const inputs = document.querySelectorAll('.form-control');
        const buttons = document.querySelector('.buttons');
        const form = document.querySelector('.thesis-edit');

        const enableEdit = () =>{
            inputs.forEach(input =>{
                input.disabled = false; 
            });
            buttons.classList.remove("d-none");
        }
        const disableEdit = () =>{
            inputs.forEach(input =>{
                input.disabled = true;
            });
            buttons.classList.add("d-none");
        }

        const setError = (element, message) =>{
            const label = element.previousElementSibling;
            const error = element.nextElementSibling;

            label.classList.add("text-danger");
            element.classList.add("border-danger");

            error.textContent= message;
        }

        const setSuccess = element =>{
            const label = element.previousElementSibling;
            const error = element.nextElementSibling;

            label.classList.remove("text-danger");
            element.classList.remove("border-danger");

            error.textContent= "";
        }

        const isEmpty = element =>{
            if(element.value === ''){
                return true;
            }
            return false;
        }

        const checkValidity = () =>{
            if(isEmpty(inputs[0])){
                setError(inputs[0], 'Please provide a call number');
                return true;
            }else{
                setSuccess(inputs[0]);
            }
            if(isEmpty(inputs[1])){
                setError(inputs[1], 'Please provide an adviser');
                return true;
            }else{
                setSuccess(inputs[1]);
            }
            if(isEmpty(inputs[2])){
                setError(inputs[2], 'Please provide a publication year');
                return true;
            }else{
                setSuccess(inputs[2]);
            }
            if(isEmpty(inputs[3])){
                setError(inputs[3], 'Please provide a number of copy');
                return true;
            }else{
                setSuccess(inputs[3]);
            }
            if(isEmpty(inputs[4])){
                setError(inputs[4], 'Please provide a title');
                return true;
            }else{
                setSuccess(inputs[4]);
            }
            if(isEmpty(inputs[5])){
                setError(inputs[5], 'Please provide an author');
                return true;
            }else{
                setSuccess(inputs[5]);
            }
            return false;
        }

        form.addEventListener('submit', e=>{
            if(checkValidity()){
                e.preventDefault();
                e.stopPropagation();
            }
        });
    </script>
    </body>
</html>
