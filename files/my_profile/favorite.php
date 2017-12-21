<?php include(__DIR__.'/../vip_pay_checkout.php');?>
<div class="favorite_users text-center">
<?php if($_SESSION['account_type']==2){ ?>
    <ul class="nav nav-tabs nav-pills nav-justified" role="tablist">
        <li class="active col-xs-6"><a href="#favorite" role="tab" data-toggle="tab">Ulubieni użytkownicy</a></li>
        <li class="col-xs-6"><a href="#blocked" role="tab" data-toggle="tab">Użytkownicy zablokowani</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="favorite">
            <div class="text-center profile_list">
<?php
    $table='favorite_users';
    $table2='users_info';
    $table3='users';
    $sql="SELECT * FROM $table WHERE user_name1='".$_SESSION['usr_name']."' ORDER BY data DESC";
    $res=$con->query($sql);
    if($res->num_rows>0){
        while($fav=$res->fetch_array()) {
            $sql2 = "SELECT * FROM $table2 INNER JOIN $table3 ON $table2.user_name=$table3.name WHERE user_name='"
                . $fav['user_name2'] . "'";
            $result = $con->query($sql2);
            while ($profile = $result->fetch_array()) {
                user_profile($profile);
            }
        }
    }else{
        echo '<p class="alert alert-info">Jeszcze żadnego z użytkowników naszego serwisu nie dodałeś do ulubionych</p>';
    }?>
            </div>
        </div>
        <div class="tab-pane" id="blocked">
            <div class="text-center profile_list">
                <?php
                $table='blocked_users';
                $table2='users_info';
                $table3='users';
                $sql="SELECT * FROM $table WHERE user_name1='".$_SESSION['usr_name']."' ORDER BY data DESC";
                $res=$con->query($sql);
                if($res->num_rows>0){
                    while($fav=$res->fetch_array()) {
                        $sql2 = "SELECT * FROM $table2 INNER JOIN $table3 ON $table2.user_name=$table3.name WHERE user_name='"
                            . $fav['user_name2'] . "'";
                        $result = $con->query($sql2);
                        while ($profile = $result->fetch_array()) {
                            user_profile($profile);
                        }
                    }
                }else{
                    echo '<p class="alert alert-info">Żaden z użytkowników naszego serwisu nie został przez Ciebie 
                    zablokowany</p>';
                }?>
                </div>
        </div>
        </div>
<?php
}else{
    echo '<p class="alert alert-warning">Opcja dostępna wyłącznie dla posiadaczy konta VIP, <a href="doladuj.php">zmień swoje konto na 
    VIP</a></p>';
}?>
</div>