<?php session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';
if (!isset($_SESSION['usr_id'])) {
    header("Location:login.php");
}?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $config->getConfig()->name?> - Napisz wiadomość</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php include ('files/head.php');?>
</head>
<body>
<?php include('files/header.php');?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-9 main pull-right">
                    <?php
                        if(isset($_GET['with'])){
                            include ('files/message/write_message.php');
                        }elseif((isset($_GET['to']))&&(isset($_GET['from']))&&($_SESSION['usr_role']=='super_admin')){
                            include ('files/users/messages.php');
                        }else{
                            header('Location:index.php');
                        }

                    ?>
                </div>
            </div>
            <div class="col-sm-3 sidebar"><?php include('files/sidebar.php');?></div>
        </div>
    </div>
</section>
<footer>
    <div class="container">
        <div class="row">
            <?php include('files/footer.php');?>
        </div>
    </div>
</footer>
</body>
</html>