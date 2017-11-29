<?php
include('activate_modal.php');
$table="notifications";
$sql="SELECT count(id) as ile FROM $table WHERE (user_to='".$_SESSION['usr_name']."' AND status='0')";
$count=$con->query($sql);
$ile=$count->fetch_assoc()['ile'];
if($_SESSION['usr_role']=='super_admin'){
    $table2="users";
    $sql2="SELECT count($table.id) as ile FROM $table WHERE (user_to IN (SELECT $table2.name FROM $table2 WHERE role='fake') AND status='0')";
    $count=$con->query($sql2);
    $ile_fake=$count->fetch_assoc()['ile'];
}
if($_SESSION['usr_role']!='super_admin'){
    $coins=coins_status($_SESSION['usr_name'],$con);
}
$table3="messages";
if((stristr($_SERVER['PHP_SELF'],'message.php')=='message.php')&&(isset($_GET['with']))) {
    $sql_mess = "UPDATE $table3 SET unread='1' WHERE user_to='" . $_SESSION['usr_name'] . "' AND user_from='" . $_GET['with'] . "'";
    $con->query($sql_mess);
}
$sql_m="SELECT * FROM $table3 WHERE (user_to='".$_SESSION['usr_name']."' AND unread='0') GROUP BY user_from";
$result = $con->query($sql_m);
if ($result->num_rows > 0) {
$mess=$result->num_rows;
}


?>
<header class="navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-8">
                    <form class="navbar-form navbar-left" role="search" action="search.php">
                        <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Szukaj..." required>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 text-right">
                    <div class="notifications_container">
                        <?php
                        if($_SESSION['account_type']=='2'){ ?>
                        <span class="vip" title="Posiadasz konto VIP">
                            <i class="fa fa-trophy" aria-hidden="true"></i>
                        </span>
                        <?php }else{
                        if(isset($coins)){ ?>
                            <span class="coins" title="Posiadasz <?php echo $coins;?> punktów do wydania w naszym portalu">
                            <i class="fa fa-gg-circle" aria-hidden="true"></i> <?php echo $coins;?>
                        </span>
                            <a href="doladuj.php" class="plus"><button title="Dodaj punkty"><i class="fa
                            fa-plus-circle" aria-hidden="true"></i></button> Dodaj punkty</a>
                        <?php }

                        }?>

                        <a href="my_profile.php?action=messages" class="messages" title="Wiadomości">
                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                            <?php
                            if(@$mess>0){
                                echo '<span>'.$mess.'</span>';
                            }
                            ?>
                        </a>
                        <a href="my_profile.php?action=notifications" class="notification user" title="Powiadomienia">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <?php
                            if($ile>0){
                              echo '<span>'.$ile.'</span>';
                            }
                            ?>
                        </a>
                        <?php
                        if($_SESSION['usr_role']=='super_admin'){?>
                            <a href="users.php?action=notifications" class="notification fake" title="Powiadomienia użytkowników">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <?php
                                if($ile_fake>0){
                                    echo '<span>'.$ile_fake.'</span>';
                                }
                                ?>
                            </a>
                        <?php }?>
                        <a href="logout.php" title="Wyloguj">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>