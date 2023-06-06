
    
    
    <script src="../balayanlms/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../balayanlms/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../balayanlms/node_modules/chart.js/dist/chart.umd.js"></script>
    <script src="../balayanlms/chart/donutChart.js"></script>

    <?php if(isset($_SESSION['status'])):?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['statusIcon'];?>',
                title: '<b><?php echo $_SESSION['statusTitle'];?></b>',
                text: '<?php echo $_SESSION['statusText'];?>',
            })
        </script>
        <?php 
            unset($_SESSION['status']);
            unset($_SESSION['statusIcon']);
            unset($_SESSION['statusTitle']);
            unset($_SESSION['statusText']);
        ?>
    <?php endif;?>

    </body>
</html>