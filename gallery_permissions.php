<?php include_once ('files/headers.php');?>
<?php
session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';
$perm_table='gallery_permissions';
$notif_table='notifications';
$user=@$_REQUEST['user'];
$owner=@$_REQUEST['owner'];
$resp='';

if($_REQUEST['type']=='ask'){
    $perm_sql="SELECT status FROM $perm_table WHERE (gallery_owner='".$owner."' AND user='".$user."')";
    $notif_exist="SELECT * FROM $notif_table WHERE (user_to='".$owner."' AND user_from='".$user."' AND type='1')";
    $notf_sql="INSERT INTO $notif_table VALUES (NULL,'".$owner."','".$user."','1','0',NOW())";
    $notf_update="UPDATE $notif_table SET status='0',$notif_table.date=NOW() WHERE (user_to='".$owner."' AND user_from='".$user."' AND type='1')";
    $perm=$con->query($perm_sql);
    if ($perm->num_rows > 0){
        while($data = $perm->fetch_assoc()) {
            $sql="UPDATE $perm_table SET status='0',date=NOW() WHERE (gallery_owner='".$owner."' AND user='".$user."')";
        }
    }else{
        $sql="INSERT INTO $perm_table VALUES (NULL,'".$owner."','".$user."',0,NOW())";
    }
    try{
        if ($con->query($sql) === TRUE) {
            if($con->query($notif_exist)->num_rows>0){
                if($con->query($notf_update)===TRUE){
                    $resp='success';
                }
            }else{
                if($con->query($notf_sql)===TRUE){
                    $resp='success';
                }
            }
        }
    }
    catch (Exception $e){
        $resp='fail';
    }
    $result=array('resp'=>$resp);
}
if($_REQUEST['type']=='answer'){
    $notif_type=$_REQUEST['notif_type'];
    switch ($notif_type){
        case '1':
            $answer=($_REQUEST['answer']=='yes'? 1 : 0);
            $type=($_REQUEST['answer']=='yes'? 2 : 3);
            $new_type=($_REQUEST['answer']=='yes'? 4 : 5);
            if($answer==1){
                $sql="UPDATE $perm_table SET status='".$answer."' WHERE (gallery_owner='".$owner."' AND user='".$user."')";
            }else{
                $sql="DELETE FROM $perm_table WHERE (gallery_owner='".$owner."' AND user='".$user."')";
            }
            $sql2="INSERT INTO $notif_table VALUES (NULL,'".$user."','".$owner."','".$type."','0',NOW())";
            $sql_up="UPDATE $notif_table SET type='".$new_type."',date=NOW(),status='1' WHERE (user_to='".$owner."' AND user_from='".$user."' AND type='".$notif_type."')";
            $sql_id="SELECT id FROM $notif_table WHERE (user_to='".$owner."' AND user_from='".$user."' AND type='".$new_type."')";
            try{
                if($con->query($sql)===TRUE){
                    if(($con->query($sql2)===TRUE)&&($con->query($sql_up)===TRUE)){
                        $resp='success';
                        $id=$con->query($sql_id)->fetch_assoc()['id'];
                    }
                }
            }
            catch (Exception $e){
                $resp='fail';
            }
            break;
        default:
            break;
    }

    $result=array('resp'=>$resp,'id'=>$id);
}
if($_REQUEST['type']=='delete'){
    $id=$_REQUEST['notif'];
    $sql="DELETE FROM $notif_table WHERE id='".$id."'";
    try{
        if($con->query($sql)===TRUE){
            $resp='success';
        }
    }
    catch (Exception $e){
        $resp='fail';
    }
    $result=array('resp'=>$resp);
}
echo json_encode($result);
?>