<?php include_once ('files/headers.php');?>
<?php
session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';
$key=$_POST['key'];
if($key===ACTIVATE_CODE){
    $table='users';
    $sql="UPDATE $table SET activate='1' WHERE name='".$_SESSION['usr_name']."'";
    if ($con->query($sql) === TRUE) {
        $_SESSION['activate']='1';
        echo 1;
    }else{
        echo 3;
    }
}else{
    echo 2;
}
?>