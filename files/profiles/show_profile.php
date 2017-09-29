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
        <div class="profile_display col-sm-10">

            <div class="col-sm-4">
                <img src="<?php echo AVATAR_PATH.'/'.$data['avatar'];?>" class="img-responsive">
            </div>
            <div class="col-sm-8">
                <div class="col-sm-12"><h2><?php echo $data['user_name'].', '.$age;?></h2></div>
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