<?php
$table="notifications";
$up_sql="UPDATE $table SET status='1' WHERE user_to='".$_SESSION['usr_name']."'";
$con->query($up_sql);
?>
<div class="col-sm-12 notification" id="notifications">
    <h4>Powiadomienia</h4>
<?php
$sql="SELECT * FROM $table WHERE user_to='".$_SESSION['usr_name']."' ORDER BY $table.date DESC";
$result=$con->query($sql);
if ($result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
    echo '<div class="col-sm-10 panel panel-default notification-panel">
            <div class="panel-body">
            '.print_notification($data['type'],$data['user_to'],$data['user_from']).'
            <button type="button" class="close close-notif" data-dismiss="panel" data-notif="'.$data['id'].'" aria-hidden="true">×</button>
            </div>
          </div>';
    }
}else{
    echo '<p>Brak powiadomień</p>';
}
?>
</div>