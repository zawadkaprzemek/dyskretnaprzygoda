<?php include(__DIR__.'/../vip_pay_checkout.php');?>
<div class="visitors text-center">


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
                    user_profile($profile);
                }
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