<?php
if($_SESSION['account_type']==1){
    $table='vip_pay';
    $sql="SELECT * FROM $table WHERE user='".$_SESSION['usr_name']."'";
    $qu=$con->query($sql);
    if($qu->num_rows!=0){
        $res=$qu->fetch_array();
        $cookie=$res['cookie'];
        $pay_link=$res['pay_link'];
        ?>
        <div class="panel panel-warning pay_checkout">
            <div class="panel-heading"><p>Zamówiłeś konto VIP. Twoja płatność obecnie jest weryfikowana.<br>Gdy tylko zaksięgujemy środki, Twoje
                    konto zmieni się w konto VIP.</p></div>
            <div class="panel-body loading_container">
            <p class="pay_info">Kliknij poniżej, aby sprawdzić status płatności, lub - jeśli jeszcze tego nie
                zrobiłeś - aby
                opłacić
                konto VIP.</p>
            <input type="hidden" name="cookie" id="cookie" value="<?php echo $cookie;?>">
            <input type="hidden" name="user" id="user" value="<?php echo $_SESSION['usr_name'];?>">
            <button class="btn btn-warning check_vip">Sprawdź status swojej płatności</button>
            <a href="<?php echo $pay_link;?>"><button class="btn btn-info">Opłać VIP</button></a>
                <div class="loading">
                    <img src="lib/images/loading.gif" alt="">
                </div>
            </div>
        </div>
    <?php }
}else{
    if(($_SESSION['account_type']==2)&&(@$_GET['vip']=='1')){?>
        <p class="alert alert-success vip_success">Gratulacje! Twoja płatność przebiegła pomyślnie. Twoje konto zostało
            zmienione na VIP
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></p>
    <?php }
}
?>