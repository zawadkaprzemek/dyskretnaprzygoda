<?php
$table="users_info";
$user=$_SESSION['usr_name'];
$sql="SELECT * FROM $table WHERE user_name='$user'";
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
            <div class="col-sm-8"><h2>Mój profil</h2></div>
            <div class="clearfix"></div>
            <div class="col-sm-4">
                <img src="<?php echo AVATAR_PATH.'/'.$data['avatar'];?>" class="img-responsive">
            </div>
            <div class="col-sm-8">
                <div class="col-sm-12"><h2><?php echo $data['user_name'].', '.$age;?></h2> <?php echo is_vip
                    ($data['user_name'],$con)?></div>
                <div class="col-sm-4">Płeć:</div>
                <div class="col-sm-8"><?php echo $sex?></div>
                <div class="col-sm-4">Stan cywilny:</div>
                <div class="col-sm-8"><?php echo $data['state']?></div>
            </div>
            <div class="col-sm-12">O mnie:
                <p><?php echo $data['info'];?></p>
            </div>
            <?php
            include ('photos.php');
            ?>
        </div>
    <?php }

}else{
    header("Location:my_profile.php?action=edit");
}
?>