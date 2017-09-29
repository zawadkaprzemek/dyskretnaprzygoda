<?php
if(isset($_GET['action'])&&($_GET['action']=='registered_users')){
    $get='?action=registered_users';
    $a='&';
}else{
    $get='';
    $a='?';
}
?>
<div class="col-sm-12">
    <ul class="nav nav-pils">
        <li class="col-sm-4 <?php if(isset($_GET['sex'])&&($_GET['sex']=='w')){echo 'active';}?>">
            <a href="<?php echo $_SERVER['PHP_SELF'].$get.$a.'sex=w'?>">Kobiety <i class="fa fa-female" aria-hidden="true"></i>
            </a></li>
        <li class="col-sm-4 <?php if(isset($_GET['sex'])&&($_GET['sex']=='m')){echo 'active';}?>">
            <a href="<?php echo $_SERVER['PHP_SELF'].$get.$a.'sex=m'?>">Mężczyźni <i class="fa fa-male" aria-hidden="true"></i>
            </a></li>
        <li class="col-sm-4 <?php if(!isset($_GET['sex'])){echo 'active';}?>">
            <a href="<?php echo $_SERVER['PHP_SELF'].$get?>">Wszyscy <i class="fa fa-female" aria-hidden="true"> <i class="fa fa-male" aria-hidden="true"></i>
                </i>
            </a></li>
    </ul>
    <div class="tab-content">
        <?php
        $table='users';
        $table2='users_info';
        $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.name=$table2.user_name WHERE role=";
        if(isset($_GET['action'])&&($_GET['action']=='registered_users')){
            $sql.="'user'";
        }else{
            $sql.="'fake'";
        }
        if(isset($_GET['sex'])){
            $sql.=" AND sex='".$_GET['sex']."'";
        }
        $sql.=" ORDER BY name";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($profiles = $result->fetch_assoc()) {?>
                <div class="col-sm-4">
                    <img src="<?php echo AVATAR_PATH.'/'.$profiles['avatar']?>" class="img-responsive" alt="">
                    <p class="user_name"><?php echo $profiles['user_name'];?></p>
                    <p><a class="btn btn-default" href="profile.php?name=<?php echo $profiles['user_name'];?>">Pokaż profil</a>
                        <a class="btn btn-default" href="users.php?action=edit&name=<?php echo $profiles['user_name'];?>">Edytuj profil</a></p>
                </div>
            <?php }
        }
        ?>
    </div>
</div>