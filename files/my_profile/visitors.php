<?php include(__DIR__.'/../vip_pay_checkout.php');?>
<div class="col-sm-12 visitors text-center">


    <?php if($_SESSION['account_type']==2){?>
    <div class="profile_list">
        <h3>Goście Twojego profilu:</h3>
       <?php $table='profile_visit';
        $sql="SELECT * FROM $table WHERE user_name2='".$_SESSION['usr_name']."' ORDER BY data DESC LIMIT 0,"
            .$config->getConfig()->profiles_per_page."";
        $update="UPDATE $table SET checked=1 WHERE user_name2='".$_SESSION['usr_name']."'";
        $con->query($update);
        $res=$con->query($sql);
        if($res->num_rows>0) {
            $table2='users_info';
            $table3='users';
            while($visitor=$res->fetch_array()) {
                $sql2 = "SELECT * FROM $table2 INNER JOIN $table3 ON $table2.user_name=$table3.name WHERE $table2
                .user_name='" . $visitor['user_name1'] . "'";
                $result = $con->query($sql2);
                while ($profile = $result->fetch_array()) {
                    if ($profile['account_type'] == '2') {
                        $class = 'vip';
                    } else {
                        $class = 'standard';
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
                                    <a class="btn btn-primary" href="profile.php?name=<?php echo $profile['user_name'];?>">Zobacz zdjęcia</a>
                                    <a class="btn btn-default" href="message.php?with=<?php echo $profile['user_name'];?>">Wyślij wiadomość</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div></a>
                </div>
                <?php }
            }

            ?>

            <?php
        }else{
            echo '<p class="alert alert-info">Jeszcze nikt nie odwiedził Twojego profilu</p>';
        }
        ?> </div> <?php
    }else{
        echo '<p class="alert alert-warning">Opcja dostępna wyłącznie dla posiadaczy konta VIP, <a href="doladuj.php">zmień swoje konto na 
    VIP</a></p>';
    }?>

</div>