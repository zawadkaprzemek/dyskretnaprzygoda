<?php
$table="users_info";
$table2="users";
$is_info="SELECT * FROM $table WHERE user_name='".$_SESSION['usr_name']."'";
$result = $con->query($is_info);
if ($result->num_rows > 0) {
$user=$_GET['name'];
if($user==$_SESSION['usr_name']){
    header("Location:my_profile.php");
}else{
    if($_SESSION['usr_role']=='super_admin'){
        $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_name=$table2.name WHERE user_name='$user'";
    }else{
        $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_name=$table2.name WHERE user_name='$user'";
        if($config->getConfig()->display_true_users=='yes'){
            $sql.=" AND role!='super_admin";
        }else{
            $sql.=" AND role='fake'";
        }
    }
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($data = $result->fetch_assoc()) {
        if($data['date_birth']!=NULL){
            $date=strtotime($data['date_birth']);
            $roznica=(((((time()-$date)/60)/60)/24)/365);
            $arr=explode(".",$roznica);
            $wiek=str_split((string)$arr[0]);
            if(($wiek[1]>1)&&($wiek[1]<5)){
                $age=$arr[0].' lata';
            }else{
                $age=$arr[0].' lat';
            }
        }else{
            $age=$data['age'];
        }
        if($data['sex']=='w'){
            $sex="Kobieta";
        }else{
            $sex="Mężczyzna";
        }
        ?>
        <div class="profile_display col-sm-12">

            <div class="col-sm-4">
                <img src="<?php echo AVATAR_PATH.'/'.$data['avatar'];?>" class="img-responsive">
            </div>
            <div class="col-sm-8">
                <div class="col-sm-8"><h2><?php echo $data['user_name'].', '.$age;?></h2><?php echo is_vip
                    ($data['user_name'],$con)?></div>
                <div class="col-sm-4 actions">
                    <?php if($_SESSION['account_type']==2){?>
                    <input type="hidden" name="user" id="user_name" value="<?php echo $data['user_name']?>">
                    <?php
                    $fsql="SELECT * FROM favorite_users WHERE user_name1='".$_SESSION['usr_name']."' AND user_name2='"
                        .$data['user_name']."'";
                    if($con->query($fsql)->num_rows>0){
                        $fclass=' on';
                        $ftitle='Usuń z ulubionych';
                    }else{
                        $ftitle='Dodaj do ulubionych';
                    }
                    ?>
                    <span class="favorite<?php echo @$fclass?>" title="<?php echo $ftitle?>">
                        <i class="fa fa-star-o" aria-hidden="true"></i></span>
                    <?php
                    $fsql="SELECT * FROM blocked_users WHERE user_name1='".$_SESSION['usr_name']."' AND user_name2='"
                        .$data['user_name']."'";
                    if($con->query($fsql)->num_rows>0){
                        $bclass=' on';
                        $btitle='Odblokuj użytkownika';
                    }else{
                        $btitle='Zablokuj użytkownika';
                    }
                    ?>
                    <span class="blocked<?php echo @$bclass?>" title="<?php echo $btitle?>">
                        <i class="fa fa-ban" aria-hidden="true"></i></span>
                <?php }?>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-4">Płeć:</div>
                <div class="col-sm-8"><?php echo $sex?></div>
                <div class="col-sm-4">Stan cywilny:</div>
                <div class="col-sm-8"><?php echo $data['state']?></div>

            </div>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <a class="btn btn-default btn-message" href="message.php?with=<?php echo $data['user_name'];?>">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                     Wyślij wiadomość</a>
            </div>
            <div class="clearfix"></div>
            <?php if($_SESSION['usr_role']=='super_admin'){ ?>
                <div class="col-sm-4">
                    <a class="btn btn-default btn-message" href="users.php?action=edit&name=<?php echo $data['user_name'];?>">
                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        Edytuj profil</a>
                </div>
                <div class="clearfix"></div>
            <?php } ?>
            <div class="col-sm-12">O mnie:
                <p><?php echo $data['info'];?></p>
            </div>
            <?php include('photos.php');?>
        </div>
    <?php }

}else{
    header("Location: index.php");
}

}
}else{
    header("Location:my_profile.php?action=edit");
}
?>