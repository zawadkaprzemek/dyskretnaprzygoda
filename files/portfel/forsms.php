<div class="row">
  <div class="col-sm-12 alert-container">

  </div>
  <div class="col-sm-6">

  <div class="leftbox">

    <div class="boxheader">
      <p><strong>Dołatuj konto</strong></p>
    </div>

    <div class="boxcontent">

    <p>Punkty dają Ci możliwość wysyłania wiadomości. Kiedy masz na koncie punkty możesz też przeglądać wszystkie profile.</p>
    <p><i>20 pkt = 1 wiadomość</i></p>

    <p class="pli">1000 pkt za <strong>30,75 zł</strong></p>
    <p>&nbsp;</p>
    <p class="pli last">Wyślij SMS o treści <strong>GMC</strong> na numer <strong>607767767</strong> W odpowiedzi otrzymasz kod, który należy wpisać w poniższe pole:</p>
  <form action="checkcode.php" id="searchForm">
    <input type="text" class="form-control" id="code_input" required>
    <input type="submit" id="fmp-button" class="cbtn" value="odbieram punkty"/>
  </firm>
  </div>

  </div>

  </div>
  <div class="col-sm-6">


        <?php
        if($_SESSION['account_type']==1) {
          $table = 'vip_pay';
          $sql = "SELECT * FROM $table WHERE user='" . $_SESSION['usr_name'] . "'";
          $qu = $con->query($sql);
          if ($qu->num_rows != 0) {
            $res = $qu->fetch_array();
            $cookie = $res['cookie'];
            $pay_link = $res['pay_link'];
            ?>
          <div class="rightbox pay_checkout">
            <div class="boxheader">
              <p><strong>Zmień konto na VIP</strong></p>
            </div>
            <div class="boxcontent">
              <p>Zamówiłeś konto VIP. Twoja płatność obecnie jest weryfikowana.<br>Gdy tylko
                  zaksięgujemy środki, Twoje
                  konto zmieni się w konto VIP.</p>

                <p>Kliknij w poniższy przycisk, aby sprawdzić status płatności</p>
                <input type="hidden" name="cookie" id="cookie" value="<?php echo $cookie; ?>">
                <input type="hidden" name="user" id="user" value="<?php echo $_SESSION['usr_name']; ?>">
                <button class="btn btn-warning">Sprawdź status swojej płatności</button>
                <a href="<?php echo $pay_link; ?>">
                  <button class="btn btn-info">Opłać VIP</button>
                </a>
            </div>
          <?php } else {
            ?>
        <div class="rightbox">
          <div class="boxheader">
            <p><strong>Zmień konto na VIP</strong></p>
          </div>

          <div class="boxcontent">
            <p>Zapomnij o ograniczeniach. <strong>Konto VIP daje Ci dostęp do wszystkich funkcji serwisu bez żadnych
                ograniczeń</strong>. Zmień swoje konto na konto VIP raz na zawsze – <span
                  style="background-color: yellow;">już nigdy nie będziesz musiał doładowywać konta.</span></p>
            <p style="font-size:23px; font-weight:bold;" class="last">147 zł<span
                  style="font-size:13px; font-weight:normal"></br>za dożywotnie konto VIP, zero ograniczeń</span></p>

            <a id="vip-button" href="#" class="cbtn" href="">wybieram</a>
          </div>
          <?php }
        }?>


    </div>

  </div>

</div>

<div class="row">
  <div class="col-sm-12 secure">

    <div style="font-size: 18px; line-height: 1.5em;">
      <i class="fa fa-lock" aria-hidden="true"></i><span class="sr-only"></span> Bezpieczna płatność i 100% dyskrecji
      <p style="font-size:14px;">Na Twoim rachunku pojawi się neutralna nazwa. Nikt nie dowie się za co płaciłeś.</p>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <div class="tablediv">
    <table class="table">

      <tr>
        <td><strong><i>Porównaj konta</i></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td><strong>Funkcja</strong></td>
        <td class="function disfunction"><strong>Konto standard</strong></td>
        <td class="function disfunction"><strong>Konto VIP</strong></td>
      </tr>

      <tr>
        <td>Tworzenie i edycja własnego profilu</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Dodawanie zdjęć</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Oglądanie zdjęć</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Profil w wynikach wyszukiwania</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Powiadomienia o wiadomościach</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Powiadomienia o zdarzeniach</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Odbieranie wiadomości</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Wysyłanie wiadomości</td>
        <td class="partial">ograniczone</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Przeglądanie profili innych użytkowników</td>
        <td class="partial">ograniczone</td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Blokowanie niechcianych użytkowników</td>
        <td class="non"><i class="fa fa-times-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Dodawanie użytkowników do obserwowanych</td>
        <td class="non"><i class="fa fa-times-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

      <tr>
        <td>Wiesz kto oglądał Twój profil</td>
        <td class="non"><i class="fa fa-times-circle" aria-hidden="true"></i></td>
        <td class="function included"><i class="fa fa-check-circle" aria-hidden="true"></i></td>
      </tr>

    </table>

  </div>
 </div>
</div>
<script>
$(document).ready(function(){

  $('#searchForm').submit(function(e){
    e.preventDefault();
    var s=$('#code_input').val();
    var name='<?php echo $_SESSION['usr_name']?>';
    $('.alert-container .alert').remove();
    var action='check_sms';
    jQuery.ajax({
              url: "ajax/vip_pay.php",
              type:"POST",
              data: {s:s,action:action,user:name},
              success:function(result) {
                var resp=JSON.parse(result);
                var alert, message;
                switch(resp['status']){
                  case 'OK':
                    alert='success';
                    message='Podany kod jest prawidłowy, punkty zostały dodane do Twojego konta!';
                    break;
                  case 'INACTIVE':
                    alert='warning';
                      switch (resp['code']){
                        case '2001':
                          message='Podany kod nie został jeszcze aktywowany';
                          break;
                        case '2002':
                          message='Podany kod został już użyty';
                          break;
                        case '2003':
                          message='Podany kod stracił ważność';
                          break;
                        case '2004':
                          message='Podano zły kod';
                          break;
                        default:
                          message='Podano zły kod';
                      }
                    break;
                  case 'ERROR':
                    alert='danger';
                    message='Wystąpił błąd, spróbuj ponownie';
                    break;
                  default:
                    alert='danger';
                    message='Wystąpił błąd, spróbuj ponownie';
                }
                $('.alert-container').append('<div class="alert alert-'+alert+'">'+message+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                if(resp.status=='OK'){
                    $('span.coins').html('<i class="fa fa-gg-circle" aria-hidden="true"></i> '+resp.coins+' ');
                    $('span.coins').prop('title','Posiadasz '+resp.coins+' punktów do wydania w naszym portalu');
                }
              }
            });
            return false;
  });

  jQuery('#vip-button').click(function(event){
    event.preventDefault();
    var email='<?php echo $email?>';
    var name='<?php echo $_SESSION['usr_name']?>';
    var action='get_and_save_order';
    jQuery.ajax({
      url: "ajax/vip_pay.php",
      type:"POST",
      data: {email:email,name:name,action:action},
      success:function(result) {
        var resp=JSON.parse(result);
        if(resp.resp=='success'){
          window.location.href=resp.link;
        }
      }
    });
  });
});


</script>
