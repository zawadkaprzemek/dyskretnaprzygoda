<?php
$table="messages";
$table2="users";
$table3="users_info";
$is_info="SELECT * FROM $table3 WHERE user_name='".$_SESSION['usr_name']."'";
$result = $con->query($is_info);
if ($result->num_rows > 0) {
$profile_exist = "SELECT * FROM $table2 ";
if ($config->getConfig()->display_fake == 'yes') {
    if ($config->getConfig()->display_true_users == 'yes') {
        $sql = "SELECT * FROM $table INNER JOIN $table2 ON $table.name=$table2.user_name WHERE $table.role='fake' OR role='user'";
        $profile_exist .= "WHERE name='" . $_GET['with'] . "' AND (role='fake' OR role='user')";
    } else {
        $profile_exist .= "WHERE name='" . $_GET['with'] . "' AND role='fake'";
    }
} else {
    $profile_exist .= "WHERE name='" . $_GET['with'] . "' AND role='user'";
}
if (($_GET['with'] == $_SESSION['usr_name']) || ($con->query($profile_exist)->num_rows == 0)){
    header("Location:index.php");
}else{
$sql_mess = "UPDATE $table SET unread='1' WHERE user_to='" . $_SESSION['usr_name'] . "' AND user_from='" . $_GET['with'] . "'";
$con->query($sql_mess);
if (isset($_POST['message'])) {
    $message = mysqli_real_escape_string($con, $_POST['message']);
    if ($message != '') {
        $user_from = $_POST['user_from'];
        $user_to = $_POST['user_name'];

        if(send_message($user_from,$user_to,$message,$_SESSION['account_type'],$config->getConfig()->prices->message,$con)){
            header("Location:" . $_SERVER['PHP_SELF'] . "?with=" . $_GET['with']);
        }else{
            if(coins_status($_SESSION['usr_name'],$con)<$config->getConfig()->prices->message){
                $errormsg = "Masz za mało punktów aby wysłać wiadomość";
            }else{
                $errormsg = "Popraw wiadomość";
            }

        }
    }
}
if(($_SESSION['account_type']=='1')&&(coins_status($_SESSION['usr_name'],$con)<$config->getConfig()->prices->message)){
    $disabled='disabled=true';
}
$bsql="SELECT * FROM blocked_users WHERE user_name1='".$_GET['with']."' AND user_name2='".$_SESSION['usr_name']."'";
$res=$con->query($bsql);
if($res->num_rows>0){
    $disabled='disabled=true';
    $blocked=true;
}
?>
<div class="col-sm-12" id="chat" xmlns="http://www.w3.org/1999/html">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span class="glyphicon glyphicon-comment"></span> Chat z <?php echo "<a target='_blank' href='profile.php?name=".$_GET['with']."'>".$_GET['with']."</a>";?>
        </div>
        <div class="panel-body">
            <ul class="chat">
                <?php
                $table = "messages";
                $table2 = "users_info";
                $user_from = $_SESSION['usr_name'];
                $user_to = $_GET['with'];
                $sql2 = "SELECT * FROM $table INNER JOIN $table2 ON $table.user_from=$table2.user_name WHERE (user_from='$user_from' AND user_to='$user_to') OR (user_from='$user_to' AND user_to='$user_from') ORDER BY data_mess ASC";
                $result = $con->query($sql2);
                if ($result->num_rows > 0) {
                    while ($messages = $result->fetch_assoc()) { ?>
                        <?php if ($messages['user_from'] == $_SESSION['usr_name']) {
                            $leftright = "right";
                        } else {
                            $leftright = "left";
                        }
                        $d=nice_data($messages['data_mess'],$month_names);
                        ?>
                        <li class="<?php echo $leftright; ?> clearfix"><span
                                class="chat-img pull-<?php echo $leftright; ?>">
                            <img src="<?php echo AVATAR_PATH.'/'.$messages['avatar']; ?>" alt="User Avatar"
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
                    <li>Jeszcze nie ma żadnych wiadomości między Wami, zrób pierwszy krok i napisz...</li>
                <?php }
                if(empty(is_vip($_SESSION['usr_name'],$con))&&(coins_status($_SESSION['usr_name'],$con)<$config->getConfig()->prices->message)){
                    ?>
                <li>
                    Masz konto standard i skończyły Ci się punkty. Chcesz dalej rozmawiać z użytkownikiem
                    <strong><?php echo $_GET['with']?></strong>? Zmień teraz konto na VIP, albo doładuj swoje konto punktami. Kliknij w poniższy
                    przycisk. <a href="doladuj.php" class="plus"><button title="Dodaj punkty"><i class="fa
                            fa-plus-circle" aria-hidden="true"></i></button> Dodaj punkty</a>
                </li>
               <?php }
                if(@$blocked==true){
                    echo '<li>Użytkownik <strong>'.$_GET['with'].'</strong> zablokował Cie i nie chce z Tobą 
                    rozmawiać!</li>';
                }
                ?>
            </ul>
        </div>
        <div class="panel-footer">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>?with=<?php echo $_GET['with'] ?>"
                  method="post" name="messageform" id="messageform" <?php echo @$disabled;?> >
                <div class="input-group">
                    <textarea id="message-input" <?php echo @$disabled;?> type="text" data-emojiable="true" name="message" class="form-control wdt-emoji-bundle-enabled wdt-emoji-open-on-colon input-sm" placeholder="..."
                              required></textarea>
                    <span class="input-group-btn">
                            <input type="submit" <?php echo @$disabled;?> class="btn btn-warning btn-sm" id="btn-chat" name="write_message" value="Wyślij"/>
                        </span>

                </div>
                <div class="form-group hidden">
                    <input type="hidden" name="user_name" value="<?php echo $_GET['with'] ?>">
                    <input type="hidden" name="user_from" value="<?php echo $_SESSION['usr_name'] ?>">
                </div>
            </form>
            <div>
                <?php include('files/emoji-picker.php');?>
            </div>

        </div>

    </div>
    <?php if(isset($errormsg)){
        echo '<p class="alert-warning alert">'.$errormsg.'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>';
    }?>


    <?php }
    }else{
        header("Location:my_profile.php?action=edit");
    }
    include('files/emoji-script.php');
?>
