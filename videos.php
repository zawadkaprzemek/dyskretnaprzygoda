<?php include_once ('files/headers.php');?>
<?php session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';
if (!isset($_SESSION['usr_id'])) {
    header("Location:login.php");
}?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title><?php echo $config->getConfig()->name?></title>
    <?php include ('files/head.php');?>
    <link href="lib/css/video-js.css" rel="stylesheet">

    <!-- If you'd like to support IE8 -->
    <script src="lib/js/videojs-ie8.min.js"></script>
</head>
<body>
<?php include('files/header.php');?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-9 main pull-right">
                    <?php
                    include('files/videos/videos.php');
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