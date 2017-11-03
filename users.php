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
    <title><?php echo $config->getConfig()->name?> - Użytkownicy</title>
    <?php include ('files/head.php');?>
    <link rel="stylesheet" type="text/css" href="lib/css/users.css">
</head>
<body>
<?php include('files/header.php');?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-9 main pull-right">
                    <?php
                    if($_SESSION['usr_role']=='super_admin'){
                        if(!isset($_GET['action'])) {
                            include('files/users/show.php');
                        }else{
                            if($_GET['action']=='add'){
                                include ('files/users/add.php');
                            }elseif ($_GET['action']=='messages_list'){
                                include ('files/users/messages_list.php');
                            }elseif ($_GET['action']=='messages'){
                                include ('files/my_profile/messages.php');
                            }elseif ($_GET['action']=='edit'){
                                include ('files/users/edit.php');
                            }elseif ($_GET['action']=='registered_users'){
                                include ('files/users/show.php');
                            }elseif ($_GET['action']=='notifications'){
                                include ('files/users/notifications.php');
                            }else{
                                header("Location:users.php");
                            }
                        }
                    }else{
                        header("Location:index.php");
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