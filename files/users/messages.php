<?php
$table="messages";
$table2="users";
$table3="users_info";
$is_info="SELECT * FROM $table3 WHERE user_name='".$_SESSION['usr_name']."'";
$result = $con->query($is_info);
if ($result->num_rows > 0) {
$profile_exist = "SELECT * FROM $table2 WHERE name='" . $_GET['to'] . "' ";
$profile_exist2 = "SELECT * FROM $table2 WHERE name='" . $_GET['from'] . "' ";
if ($config->getConfig()->display_fake == 'yes') {
    if ($config->getConfig()->display_true_users == 'yes') {
        $sql = "SELECT * FROM $table INNER JOIN $table2 ON $table.name=$table2.user_name WHERE $table.role='fake' OR role='user'";
        $profile_exist .= "AND (role='fake' OR role='user')";
    } else {
        $profile_exist .= "AND role='fake'";
    }
} else {
    $profile_exist .= "AND role='user'";
}
if (($_GET['to'] == $_SESSION['usr_name']) ||($_GET['from'] == $_SESSION['usr_name']) || ($con->query($profile_exist)->num_rows == 0)||($con->query($profile_exist2)->num_rows == 0)){
    header("Location:index.php");
}else{
$sql_mess = "UPDATE $table SET unread='1' WHERE user_to='" . $_GET['to'] . "' AND user_from='" . $_GET['from'] . "'";
$con->query($sql_mess);
if (isset($_POST['message'])) {
    $message = trim(mysqli_real_escape_string($con, $_POST['message']));
    if ($message != '') {
        $user_from = $_POST['user_from'];
        $user_to = $_POST['user_to'];
        $sql = "INSERT INTO $table (id,user_from,user_to,message,data_mess,unread) VALUES(NULL,'$user_from','$user_to','$message',NOW(),0)";
        if ($con->query($sql) === TRUE) {
            header("Location:" . $_SERVER['PHP_SELF'] . "?to=".$_GET['to']."&from=".$_GET['from']);
        } else {
            $errormsg = "Popraw wiadomość";
        }
    }
}
$bsql="SELECT * FROM blocked_users WHERE user_name1='".$_GET['from']."' AND user_name2='".$_GET['to']."'";
$res=$con->query($bsql);
if($res->num_rows>0){
    $disabled='disabled=true';
    $blocked=true;
}
?>
<div class="col-sm-12" id="chat" xmlns="http://www.w3.org/1999/html">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-comment"></span> Chat z <a href="profile.php?name=<?php echo $_GET['from'];
            ?>&ref_user=<?php echo $_GET['to']?>" target="_blank"><?php echo $_GET['from'];?></a>
            <?php
            $vip=is_vip($_GET['from'],$con);
            if(empty($vip)){ ?>
            <i class="fa fa-gg-circle" aria-hidden="true"></i> <?php echo coins_status($_GET['from'],$con);?>
            <?php }else{
                echo $vip;
            }?>
        </div>
        <div class="panel-body">
            <ul class="chat">
                <?php
                $table = "messages";
                $table2 = "users_info";
                $user_from = $_GET['from'];
                $user_to = $_GET['to'];
                $sql2 = "SELECT * FROM $table WHERE (user_from='$user_from' OR user_to='$user_from') AND (user_from='$user_to' OR user_to='$user_to') ORDER BY data_mess ASC";
                $result = $con->query($sql2);
                if ($result->num_rows > 0) {
                    while ($messages = $result->fetch_assoc()) { ?>
                        <?php if ($messages['user_from'] == $_GET['to']) {
                            $leftright = "right";
                        } else {
                            $leftright = "left";
                        }
                        $d=nice_data($messages['data_mess'],$month_names);
                        $avatar_query="SELECT avatar FROM $table2 WHERE user_name='".$messages['user_from']."'";
                        $mess=$con->query($avatar_query)->fetch_assoc();
                        $messages['avatar']=$mess['avatar'];
                        if(!isset($messages['avatar'])){$avatar='default.png';}else{$avatar=$messages['avatar'];}
                        ?>
                        <li class="<?php echo $leftright; ?> clearfix"><span
                                class="chat-img pull-<?php echo $leftright; ?>">
                            <img src="<?php echo AVATAR_PATH.'/'.$avatar;?>" alt="User Avatar"
                                 class="img-rounded"/>
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font <?php if ($leftright == 'right') {
                                        echo "pull-right";
                                    } ?>"><?php echo $messages['user_from'] ?></strong>
                                    <small class="<?php if ($leftright == 'left') {
                                        echo "pull-right";
                                    } ?> text-muted">
                                        <span class="glyphicon glyphicon-time"></span><?php echo $d ?></small>
                                </div>
                                <p class="chat-message">
                                    <?php echo str_replace(array("\r\n", "\r", "\n"), " <br />",($messages['message'])) ?>
                                </p>
                            </div>
                        </li>
                    <?php } ?>

                <?php } else {
                    ?>
                    <li>Nie ma jeszcze żadnych wiadomości między tymi użytkownikami</li>
                <?php }
                if(@$blocked==true){
                    echo '<li>Użytkownik <strong>'.$_GET['from'].'</strong> zablokował Cie i nie chce z Tobą 
                    rozmawiać!</li>';
                }
                ?>
            </ul>
        </div>
        <div class="panel-footer">
            <form role="form" <?php echo @$disabled;?> action="<?php echo $_SERVER['PHP_SELF']; ?>?to=<?php echo $_GET['to'] ?>&from=<?php echo $_GET['from'] ?>"
                  method="post" name="messageform" id="messageform">
                <div class="input-group">

                    <textarea id="message-input" <?php echo @$disabled;?> type="text" data-emojiable="true" name="message" class="form-control wdt-emoji-bundle-enabled wdt-emoji-open-on-colon input-sm" placeholder="..."
                              required></textarea>
                    <span class="input-group-btn">
                            <input type="submit" <?php echo @$disabled;?> class="btn btn-warning btn-sm" id="btn-chat" name="write_message"
                                   value="Wyślij"/>
                        </span>
                    <div class="form-group">
                        <input type="hidden" name="user_to" value="<?php echo $_GET['from'] ?>">
                        <input type="hidden" name="user_from" value="<?php echo $_GET['to'] ?>">
                    </div>

                </div>
            </form>
            <div>
                <?php include('files/emoji-picker.php');?>
            </div>
        </div>
    </div>
</div>
    <?php }
    }else{
        header("Location:my_profile.php?action=edit");
    }
    include('files/emoji-script.php');
    ?>


