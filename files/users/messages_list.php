<div class="col-sm-12" xmlns="http://www.w3.org/1999/html">
    <h2>Wiadomości do użytkowników:</h2>
    <div id="accordion" class="panel-group">
    <?php
    $table2='users';
    $table3="users_info";
    $table='messages';
    $sql="SELECT name, avatar FROM $table2 INNER JOIN $table3 ON $table2.name=$table3.user_name WHERE role='fake' ORDER BY name";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($profiles = $result->fetch_assoc()) {
            $sql2 = "SELECT user_from,user_to,MAX(data_mess)as max_data FROM $table WHERE user_from='" . $profiles['name'] . "' OR user_to='" . $profiles['name'] . "' GROUP BY user_to";
            $result2 = $con->query($sql2);
            if ($result2->num_rows > 0) {
                $arr = [];
                $unread="SELECT COUNT(id) as wszystkie, (SELECT COUNT(id) as unread FROM messages WHERE user_to='".$profiles['name']."' AND unread='0') as unread FROM messages WHERE user_to='".$profiles['name']."' OR user_from='".$profiles['name']."' ";
                $result3=$con->query($unread)->fetch_assoc();
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion"
                               href="#collapse_<?php echo $profiles['name']; ?>">
                                <img src="<?php echo AVATAR_PATH.'/'.$profiles['avatar'];?>" class="img-responsive img-rounded">
                                <?php echo $profiles['name']; ?> - <strong><?php echo $result3['unread'];?></strong>/<?php echo $result3['wszystkie']?>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse_<?php echo $profiles['name']; ?>" class="panel-collapse collapse">
                        <div class="panel-body my_messages">
                            <div class="col-sm-12 messages_container">
                                <div class="col-sm-12 messages_top">
                                    <div class="col-sm-6 col-sm-offset-2"><i class="fa fa-user fa-2x" aria-hidden="true" title="Użytkownik"></i></div>
                                    <div class="col-sm-1 text-center"><i class="fa fa-comments-o fa-2x" aria-hidden="true" title="Liczba wiadomości"></i></div>
                                    <div class="col-sm-3 text-center"><i class="fa fa-clock-o fa-2x" aria-hidden="true" title="Ostatnia wiadomość"></i></div>
                                </div>

<?php while ($mess = $result2->fetch_assoc()) {
if ($mess['user_to'] == $profiles['name']) {
$count = "SELECT count(id) as howmany FROM $table WHERE (user_to='" . $profiles['name'] . "' AND user_from='" . $mess['user_from'] . "' ) 
OR (user_from='" . $profiles['name'] . "' AND user_to='" . $mess['user_from'] . "') ";
$ile = $con->query($count)->fetch_assoc();
$sql_last="SELECT max(data_mess) as last FROM $table WHERE (user_to='".$profiles['name']."' AND user_from='".$mess['user_from']."' ) 
OR (user_from='".$profiles['name']."' AND user_to='".$mess['user_from']."') ORDER BY data_mess DESC";
$last=$con->query($sql_last)->fetch_assoc();
$avatar_query = "SELECT avatar FROM $table3 WHERE user_name='" . $mess['user_from'] . "'";
$avatar = $con->query($avatar_query)->fetch_assoc();
$sql_unread = "SELECT count(id) as status FROM $table WHERE user_to='" . $profiles['name'] . "' AND user_from='" . $mess['user_from'] . "' AND unread='0'";
$unread = $con->query($sql_unread)->fetch_assoc();
$add = array(
    'name' => $mess['user_from'],
    'count' => $ile['howmany'],
    'avatar' => $avatar['avatar'],
    'unread' => $unread['status'],
    'date' => $last['last'],
);
} else {
$count = "SELECT count(id) as howmany FROM $table WHERE (user_to='" . $profiles['name'] . "' AND user_from='" . $mess['user_to'] . "' ) 
OR (user_from='" . $profiles['name'] . "' AND user_to='" . $mess['user_to'] . "') ";
$ile = $con->query($count)->fetch_assoc();
$sql_last="SELECT max(data_mess) as last FROM $table WHERE (user_to='".$profiles['name']."' AND user_from='".$mess['user_to']."' ) 
OR (user_from='".$profiles['name']."' AND user_to='".$mess['user_to']."') ORDER BY data_mess DESC";
$last=$con->query($sql_last)->fetch_assoc();
$avatar_query = "SELECT avatar FROM $table3 WHERE user_name='" . $mess['user_to'] . "'";
$avatar = $con->query($avatar_query)->fetch_assoc();
$sql_unread = "SELECT count(id) as status FROM $table WHERE user_to='" . $profiles['name'] . "' AND user_from='" . $mess['user_to'] . "' AND unread='0'";
$unread = $con->query($sql_unread)->fetch_assoc();
$add = array(
    'name' => $mess['user_to'],
    'count' => $ile['howmany'],
    'avatar' => $avatar['avatar'],
    'unread' => $unread['status'],
    'date' => $last['last'],
);
}
if (!in_array($add, $arr)) {
array_push($arr, $add);
}
} ?>
                            <?php
                            usort($arr,'sort_date');
                            foreach ($arr as $ar => $item) {
                                if ($item['unread'] > 0) {
                                    $class = "bold";
                                } else {
                                    $class = "";
                                }
                                if($item['avatar']==''){
                                    $item['avatar']='default.png';
                                }
                                $item['date']=nice_data($item['date'],$month_names);
                                ?>
                                <div class="col-sm-12 panel panel-default">
                                    <a class="<?php echo $class; ?> panel-body" href="message.php?to=<?php echo $profiles['name'] ?>&from=<?php echo $item['name'] ?>">
                                        <div class="col-sm-2"><img
                                                src="<?php echo AVATAR_PATH . '/' . $item['avatar'] ?>"
                                                class="img-responsive img-rounded"></div>
                                        <div class="col-sm-4"><?php echo $item['name'] ?></div>
                                        <div class="col-sm-3 text-center">Nieprzeczytane: <?php echo $item['unread'] ?></div>
                                        <div class="col-sm-3 text-center"><?php echo $item['date'] ?></div>
                                    </a>
                                </div>
                            <?php } ?>
                                </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
    }
    ?>
    </div>
</div>
