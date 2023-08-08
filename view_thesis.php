<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id= '';
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
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
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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
                                        id="publisher"
                                        name="publisher" 
                                        value="<?php echo htmlspecialchars($thesis['adviser'])?>"
                                        disabled>
                                    <span class="text-danger"></span>
                                </div>
                                <div class="mb-3 mx-5">
                                    <label for="copyright" class="form-label text-secondary fw-bold">Publication Year</label>
                                    <input type="text" 
                                        class="form-control ms-1" 
                                        id="copyright"
                                        name="copyright" 
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
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']);?>">
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

        const enableEdit = () =>{
            inputs.forEach(input =>{
                if(input.getAttribute("name") != 'accessnum'){
                    input.disabled = false; 
                }
            });
            buttons.classList.remove("d-none");
        }
        const disableEdit = () =>{
            inputs.forEach(input =>{
                if(input.getAttribute("name") != 'accessnum'){
                    input.disabled = true; 
                }
            });
            buttons.classList.add("d-none");
        }
    </script>
    </body>
</html>
