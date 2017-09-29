<?php session_start();
include_once 'conf/config.php';
include_once 'conf/data_base.php';
if (!isset($_SESSION['usr_id'])) {
    header("Location:login.php");
}?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $config->getConfig()->name?> - Mój profil</title>
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
                    if(!isset($_GET['action'])){
                        include ('files/my_profile/show.php');
                    }else{
                        if($_GET['action']=='edit'){
                            include ('files/my_profile/edit.php');
                        }elseif ($_GET['action']=='upload_photos'){
                            include ('files/my_profile/upload_photos.php');
                        }elseif ($_GET['action']=='messages'){
                            include ('files/my_profile/messages.php');
                        }
                    }
                    ?>
                </div>
                <div class="col-sm-3 sidebar"><?php include('files/sidebar.php');?></div>
            </div>
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