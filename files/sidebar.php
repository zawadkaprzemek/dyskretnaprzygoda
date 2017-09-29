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
<div class="menu-list">
<div <?php if(stristr($_SERVER['PHP_SELF'],'index.php')=='index.php'){ echo 'class="active"';}?>>
    <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i>Strona główna</a>
</div>
<div <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&((!isset($_GET['action'])))){ echo 'class="active"';}?>>
    <a href="my_profile.php"><i class="fa fa-user" aria-hidden="true"></i>Mój profil</a>
</div>
<div <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='edit'))){ echo 'class="active"';}?>>
    <a href="my_profile.php?action=edit"><i class="fa fa-pencil-square" aria-hidden="true"></i>Edytuj profil</a>
</div>
<div <?php if((stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php')&&(($action=='messages'))){ echo 'class="active"';}?>>
    <a href="my_profile.php?action=messages"><i class="fa fa-comments" aria-hidden="true"></i>Wiadomości<?php
        $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_from=$table2.user_name
        WHERE (user_to='".$_SESSION['usr_name']."' AND unread='0') GROUP BY user_from";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {?>
            <span class="circle"><?php echo $result->num_rows;?></span>
        <?php }
        ?></a>
</div>
    <hr>
    <?php
    if($_SESSION['usr_role']=='super_admin'){?>
        <div <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&((!isset($_GET['action'])))){ echo 'class="active"';}?>>
            <a href="users.php"><i class="fa fa-users" aria-hidden="true"></i>Lista użytkowników</a>
        </div>
        <div <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='registered_users'))){ echo 'class="active"';}?>>
            <a href="users.php?action=registered_users"><i class="fa fa-registered" aria-hidden="true"></i>Zarejestrowani użytkownicy</a>
        </div>
        <div <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='add'))){ echo 'class="active"';}?>>
            <a href="users.php?action=add"><i class="fa fa-user-plus" aria-hidden="true"></i>Dodaj użytkowników</a>
        </div>
        <div <?php if((stristr($_SERVER['PHP_SELF'],'users.php')=='users.php')&&(($action=='messages_list'))){ echo 'class="active"';}?>>
            <a href="users.php?action=messages_list"><i class="fa fa-comments-o" aria-hidden="true"></i>Lista wiadomości </a>
        </div>
        <hr>
    <?php }?>
<div><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Wyloguj</a></div>
</div>
<?php
?>