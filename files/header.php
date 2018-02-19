<?php
include('activate_modal.php');
if(isset($_GET['action'])){
    $action=$_GET['action'];
}else{
    $action='';
}
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
$vsql="SELECT count(user_name1) as ile FROM profile_visit WHERE (user_name2='".$_SESSION['usr_name']."' AND 
        checked='0')";
        $vresult = $con->query($vsql);
        $ilev=$vresult->fetch_array()['ile'];
?>
<div class="container-fluid">
<div class="row">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <div class="navbar-header">
                    <div class="search-container">
                    <form class="navbar-form navbar-left" role="search" action="search.php">
                        <div class="form-group">
                            <input type="text" name="search" id="search" class="form-control" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Szukaj..." required>
                        </div>
                    </form>
                    </div>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                        <span class="sr-only">Nawigacja</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                    <div class="col-sm-6 col-xs-12 collapse navbar-collapse navbar-right" id="main-menu">
                        <ul class="nav navbar-nav text-right">
                            <li class="visible-sm visible-xs <?php if(stristr($_SERVER['PHP_SELF'],'index.php')=='index.php'){ echo 'active';}?>">
                                <a href=".">
                                    <strong class="visible-xs-inline">Strona główna</strong>
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                </a></li>
                            <li class="visible-sm visible-xs <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&((!isset($_GET['action'])))){ echo 'active';}?>">
                                <a href="my_profile.php">
                                    <strong>Mój profil</strong>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="visible-sm visible-xs <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='edit'))){ echo 'active';}?>">
                                <a href="my_profile.php?action=edit">
                                    <strong>Edytuj profil</strong>
                                    <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                            <?php
                            if($_SESSION['account_type']=='2'){ ?>
                                <a href="#">
                                <span class="vip" title="Posiadasz konto VIP">
                                    <strong class="visible-xs-inline">Posiadasz konto VIP</strong>
                                <i class="fa fa-trophy" aria-hidden="true"></i>
                                </span></a>
                            <?php }else{
                                if(isset($coins)){ ?>
                                    <span class="coins" title="Posiadasz <?php echo $coins;?> punktów do wydania w naszym portalu">
                                    <i class="fa fa-gg-circle" aria-hidden="true"></i> <?php echo $coins;?>
                                    </span>
                 <a href="doladuj.php" class="plus"><button title="Dodaj punkty"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> Dodaj punkty</a>
                                <?php }

                            }?>
                            </li>
                            <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='messages'))){ echo 'class="active"';}?>><a href="my_profile.php?action=messages" class="messages" title="Wiadomości">
                                    <strong class="visible-xs-inline ">Wiadomości</strong>
                                    <i class="fa fa-comments-o" aria-hidden="true"></i>
                                    <?php
                                    if(@$mess>0){
                                        echo '<span class="red_circle">'.$mess.'</span>';
                                    }
                                    ?>
                                </a></li>
                            <li class="visible-sm visible-xs <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='visitors'))){
                                echo 'active';}?>">
                                <a href="my_profile.php?action=visitors">
                                    <strong>Odwiedzili mnie</strong>
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <?php if ($ilev>0) {?>
                                    <span class="red_circle"><?php echo $ilev;?></span>
                                    <?php }?>
                                </a>
                            </li>
                            <li class="visible-sm visible-xs <?php
                                if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='favorite'))){
                                echo 'active';
                            }?>">
                                <a href="my_profile.php?action=favorite">
                                    <strong>Ulubieni użytkownicy</strong>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="visible-sm visible-xs <?php if(stristr($_SERVER['PHP_SELF'],'videos.php')=='videos.php'){
                                echo 'active';}?>">
                                <a href="videos.php">
                                    <strong>Filmy użytkowników</strong>
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li><a href="my_profile.php?action=notifications" class="notification user" title="Powiadomienia">
                                    <strong class="visible-xs-inline">Powiadomienia</strong>
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                    <?php
                                    if($ile>0){
                                        echo '<span class="red_circle">'.$ile.'</span>';
                                    }
                                    ?>
                                </a></li>

                            <?php
                            if($_SESSION['usr_role']=='super_admin'){?>
                                <li><a href="users.php?action=notifications" class="notification fake" title="Powiadomienia użytkowników">
                                        <strong class="visible-xs-inline">Powiadomienia użytkowników</strong>
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                    <?php
                                    if(@$ile_fake>0){
                                        echo '<span class="red_circle">'.@$ile_fake.'</span>';
                                    }
                                    ?>

                                </a></li>
                            <?php }?>

                            <li><a href="logout.php" title="Wyloguj">
                                    <strong class="visible-xs-inline">Wyloguj</strong>
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
</div>