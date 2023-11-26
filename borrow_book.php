<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $pdo = require '/xampp/htdocs/balayanlms/configuration/connect.php';
    $id = '';
    $userType = '';

    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);
    }
    if(isset($_GET['user_type'])){
        $userType = htmlspecialchars($_GET['user_type']);
    }
?>
<?php require '../balayanlms/template/header.php';?>
    <section class="card m-3">

    </section>
<?php require '../balayanlms/template/footer.php';?>
</body>
</html>
