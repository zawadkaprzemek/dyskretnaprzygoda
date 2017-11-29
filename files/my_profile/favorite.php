<div class="col-sm-12 favorite_users">
<?php
if($_SESSION['account_type']==2){
    $table='favorite_users';
    $table2='users_info';
    $table3='users';
    $sql="SELECT user_name2 FROM $table WHERE user_name1='".$_SESSION['usr_name']."'";
    $sql2="SELECT * FROM $table2 INNER JOIN $table3 ON $table2.user_name=$table3.name WHERE user_name IN (SELECT user_name2 FROM $table WHERE user_name1='"
        .$_SESSION['usr_name']."')";
    $result=$con->query($sql2);
    if($result->num_rows>0){
        echo '<div class="text-center profile_list">';
        while($profile=$result->fetch_array()){
            if($profile['account_type']=='2'){
                $class='vip';
            }else{
                $class='standard';
            }
            ?>
            <div class="col-md-4 col-sm-6 profile <?php echo $class;?>">
                <a href="profile.php?name=<?php echo $profile['user_name'];?>">
                    <div class="thumbnail">
                        <div class="photo">
                            <img src="<?php echo AVATAR_PATH.'/'.$profile['avatar'];?>" alt="" class="thumbnail-photo">
                        </div>
                        <div class="caption">
                            <h3><?php echo $profile['user_name'].', '.$profile['age'];?></h3>
                            <h4><?php echo $profile['state'];?></h4>
                            <p class="ellipsis"><?php echo addDots($profile['info'],100);?></p>
                            <div class="buttons">
                                <a class="btn btn-primary" href="profile.php?name=<?php echo $profile['user_name'];
                                ?>">Zobacz zdjęcia</a>
                                <a class="btn btn-default" href="message.php?with=<?php echo $profile['user_name'];
                                ?>">Wyślij wiadomość</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div></a>
            </div>
        <?php }
        echo '</div>';
    }else{
        echo '<p>Jeszcze żadnego z użytkowników naszego serwisu nie dodałeś do ulubionych</p>';
    }
}else{
    echo '<p>Opcja dostępna wyłącznie dla posiadaczy konta VIP, <a href="doladuj.php">zmień swoje konto na VIP</a></p>';
}?>
</div>