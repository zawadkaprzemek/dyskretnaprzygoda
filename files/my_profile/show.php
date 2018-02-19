<?php include(__DIR__.'/../vip_pay_checkout.php');?>
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
        <div class="profile_display">

            <div class="col-sm-4 col-xs-12">
                <img src="<?php echo AVATAR_PATH.'/'.$data['avatar'];?>" class="img-responsive profile_img">
            </div>
            <div class="col-sm-8 col-xs-12 user_name">
                <div class="col-sm-8"><h2><?php echo $data['user_name'].', '.$age;?>&nbsp;<?php echo is_vip
                        ($data['user_name'],$con)?>
                    </h2></div>
            </div>
            <div class="user_info col-sm-8 col-xs-12">
                <div class="col-sm-4 col-xs-3 bold">Płeć:</div>
                <div class="col-sm-8 col-xs-9"><?php echo $sex?></div>
                <div class="col-sm-4 col-xs-3 bold">Stan cywilny:</div>
                <div class="col-sm-8 col-xs-9"><?php echo $data['state']?></div>
            </div>
            <div class="clearfix"></div>

            <div class="col-sm-12 col-xs-12 about_me">
                <p><strong>O mnie:</strong></p>
                <p><?php echo $data['info'];?></p>
            </div>
            <?php include('photos.php');?>
        </div>
    <?php }

}else{
    header("Location:my_profile.php?action=edit");
}
?>