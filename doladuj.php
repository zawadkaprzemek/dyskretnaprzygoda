<?php include_once ('files/headers.php');?>
<?php session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';
if (!isset($_SESSION['usr_id'])) {
    header("Location:login.php");
}else{
    $sql="SELECT email FROM users WHERE name='".$_SESSION['usr_name']."'";
    $email=$con->query($sql)->fetch_array()['email'];

}?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $config->getConfig()->name?> - Doładuj swoje konto</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php include ('files/head.php');?>
    <link rel="stylesheet" type="text/css" href="lib/css/portfel.css">
</head>
<body>
<?php include('files/header.php');?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-9 main pull-right">
                    <div id="portfel">
                    <?php include('files/portfel/forsms.php');?>
                    </div>
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