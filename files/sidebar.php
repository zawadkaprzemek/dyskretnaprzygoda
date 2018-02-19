<?php
$table="messages";
$table2="users_info";
$path="static/avatars";
$sql="SELECT avatar FROM $table2 WHERE user_name='".$_SESSION['usr_name']."'";
$result=$con->query($sql);
if ($result->num_rows > 0) {
    $avatar=$result->fetch_assoc()['avatar'];
}else{
    $avatar='default.png';
}
if(isset($_GET['action'])){
    $action=$_GET['action'];
}else{
    $action='';
}
?>
    <div class="user_logged">
        <div class="user_photo pull-left">
            <img src="<?php echo AVATAR_PATH.'/'.$avatar;?>" class="img-responsive img-rounded" alt="">
        </div>
        <div class="user_name">
            <p><a href="my_profile.php"><?php echo $_SESSION['usr_name'];?></a></p>
        </div>
        <div class="clearfix"></div>
    </div>
    <ul class="menu-list">
    <li <?php if(stristr($_SERVER['PHP_SELF'],'index.php')=='index.php'){ echo 'class="active"';}?>>
        <a href="."><i class="fa fa-home" aria-hidden="true"></i>Strona główna</a>
    </li>
    <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&((!isset($_GET['action'])))){
        echo 'class="active"';}?>>
        <a href="my_profile.php"><i class="fa fa-user" aria-hidden="true"></i>Mój profil</a>
    </li>
    <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='edit'))){ echo
    'class="active"';}?>>
        <a href="my_profile.php?action=edit"><i class="fa fa-pencil-square" aria-hidden="true"></i>Edytuj profil</a>
    </li>
    <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='messages'))){ echo
    'class="active"';}?>>
        <a href="my_profile.php?action=messages"><i class="fa fa-comments" aria-hidden="true"></i>Wiadomości<?php
            $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_from=$table2.user_name
            WHERE (user_to='".$_SESSION['usr_name']."' AND unread='0') GROUP BY user_from";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {?>
                <span class="circle"><?php echo $result->num_rows;?></span>
            <?php }
            ?></a>
    </li>
    <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='visitors'))){
        echo 'class="active"';}?>>
        <a href="my_profile.php?action=visitors"><i class="fa fa-eye" aria-hidden="true"></i>Odwiedzili mnie
            <?php $vsql="SELECT count(user_name1) as ile FROM profile_visit WHERE (user_name2='".$_SESSION['usr_name']."' AND 
            checked='0')";
            $vresult = $con->query($vsql);
            $ile=$vresult->fetch_array()['ile'];
            if ($ile>0) {?>
                <span class="circle"><?php echo $ile;?></span>
            <?php }
            ?>
        </a>
    </li>
    <li <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='favorite'))){
        echo 'class="active"';}?>>
        <a href="my_profile.php?action=favorite"><i class="fa fa-star" aria-hidden="true"></i>Ulubieni
            użytkownicy</a>
    </li>
    <li <?php if(stristr($_SERVER['PHP_SELF'],'videos.php')=='videos.php'){
        echo 'class="active"';}?>>
        <a href="videos.php"><i class="fa fa-video-camera" aria-hidden="true"></i>Filmy użytkowników</a>
    </li>
        <hr>
        <?php
        if($_SESSION['usr_role']=='super_admin'){?>
            <li <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&((!isset($_GET['action'])))){ echo
            'class="active"';}?>>
                <a href="users.php"><i class="fa fa-users" aria-hidden="true"></i>Lista użytkowników</a>
            </li>
            <li <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='registered_users'))){ echo 'class="active"';}?>>
                <a href="users.php?action=registered_users"><i class="fa fa-registered" aria-hidden="true"></i>Zarejestrowani użytkownicy</a>
            </li>
            <li <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='add'))){ echo 'class="active"';}?>>
                <a href="users.php?action=add"><i class="fa fa-user-plus" aria-hidden="true"></i>Dodaj użytkowników</a>
            </li>
            <li <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='messages_list'))){ echo 'class="active"';}?>>
                <a href="users.php?action=messages_list"><i class="fa fa-comments-o" aria-hidden="true"></i>Lista wiadomości </a>
            </li>
            <hr>
        <?php }?>
    <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Wyloguj</a></li>
    </ul>
<?php
?>