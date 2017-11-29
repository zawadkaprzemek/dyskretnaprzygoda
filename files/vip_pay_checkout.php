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
            <div class="panel-body">
            <p>Kliknij w poniższy przycisk, aby sprawdzić status płatności</p>
            <input type="hidden" name="cookie" id="cookie" value="<?php echo $cookie;?>">
            <input type="hidden" name="user" id="user" value="<?php echo $_SESSION['usr_name'];?>">
            <button class="btn btn-warning">Sprawdź status swojej płatności</button>
            <a href="<?php echo $pay_link;?>"><button class="btn btn-info">Opłać VIP</button></a>
            </div>
        </div>
    <?php }
}
?>