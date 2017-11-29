<?php
if(isset($_POST)){
    session_start();
    include_once '../conf/config.php';
    include_once '../conf/functions.php';
    include_once '../conf/data_base.php';

    $resp='';
    if($_POST['action']=='favorite'){
        $what=$_POST['what'];
        $user1=$_POST['user'];
        $user2=$_POST['user2'];
        $table="favorite_users";
        switch ($what){
            case 'add':
                $sql="INSERT INTO $table VALUES ('".$user1."','".$user2."',NOW())";
                break;
            case 'remove':
                $sql="DELETE FROM $table WHERE ( user_name1='".$user1."' AND user_name2='".$user2."' )";
                break;
            default:
                break;
        }
        try{
            $con->query($sql);
            $result=array('resp'=>'success');
        }
        catch (Exception $e){
            $result=array('resp'=>'fail');
        }

    }elseif ($_POST['action']=='blocked'){
        $what=$_POST['what'];
        $user1=$_POST['user'];
        $user2=$_POST['user2'];
        $table="blocked_users";
        switch ($what){
            case 'add':
                $sql="INSERT INTO $table VALUES ('".$user1."','".$user2."',NOW())";
                break;
            case 'remove':
                $sql="DELETE FROM $table WHERE ( user_name1='".$user1."' AND user_name2='".$user2."' )";
                break;
            default:
                break;
        }
        try{
            $con->query($sql);
            $result=array('resp'=>'success');
        }
        catch (Exception $e){
            $result=array('resp'=>'fail');
        }

    }

    echo json_encode($result);
}