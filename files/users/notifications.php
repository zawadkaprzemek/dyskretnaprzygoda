<?php
$table="notifications";
$table2="users";
$up_sql="UPDATE $table SET status='1' WHERE user_to='".$_SESSION['usr_name']."'";
$con->query($up_sql);
?>
    <div class="col-sm-12" id="notifications">
    <h4>Powiadomienia użytkowników</h4>
<?php
$sql="SELECT $table2.name FROM $table2 WHERE ($table2.name IN
(SELECT user_to FROM $table) AND role='fake') ORDER BY $table2.name ASC";
$result=$con->query($sql);
if ($result->num_rows > 0) {
    echo '<div class="panel-group" id="accordion">';
    while ($data = $result->fetch_assoc()) {
        $sql3="SELECT count(id) as ile FROM $table WHERE user_to='".$data['name']."'";
        $sql4="SELECT count(id) as ile FROM $table WHERE (user_to='".$data['name']."' AND status='0')";
        $all=$con->query($sql3)->fetch_array()['ile'];
        $unread=$con->query($sql4)->fetch_array()['ile'];
        echo '<div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse_'.$data['name'].'">
                    '.$data['name'].' '.$unread.'/'.$all.'
                </a>
            </h4>
        </div>
        <div id="collapse_'.$data['name'].'" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="col-sm-12 notification" id="'.$data['name'].'_notif">';
            $sql4="SELECT * FROM $table WHERE user_to='".$data['name']."' ORDER BY date DESC";
            $result2=$con->query($sql4);
            while ($data = $result2->fetch_assoc()) {
                $rsql="SELECT role FROM users WHERE name='".$data['user_to']."'";
                $role=$con->query($rsql)->fetch_array()['role'];
            echo '<div class="col-sm-10 panel panel-default notification-panel">
                    <div class="panel-body">
                    '.print_notification($data['type'],$data['user_to'],$data['user_from'],$role).'
                    <button type="button" class="close close-notif" data-dismiss="panel" data-notif="'.$data['id'].'" aria-hidden="true">×</button>
                    </div>
                  </div>';
            }
            echo '</div>
            </div>
        </div>
    </div>';
    }
    echo '</div>';
}else{
    echo '<p class="alert alert-info">Brak powiadomień</p>';
}
?>
</div>