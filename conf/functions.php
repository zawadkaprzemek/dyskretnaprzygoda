<?php
define("AVATAR_PATH",'lib/images/avatars');
define("GALLERY_PATH",'lib/images/gallery');
define("VIDEOS_PATH",'lib/video');
define("ACTIVATE_CODE",'SXC693FXCY');
$month_names=array('','styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');

function addDots($text, $limit) {

    if (strlen($text) > $limit) {
        return trim(mb_substr($text, 0, $limit,"utf-8")) . '...';
    } else {
        return $text;
    }
}
function sort_date($el1, $el2)
{
    return strcmp($el2['date'], $el1['date']);
}

function nice_data($item,$month_names){
    $date=explode(" ",$item);
    $h=explode(":",$date[1]);
    $hour=$h[0].":".$h[1];
    $today=date('Y-m-d');
    $a=explode("-",$date[0]);
    if($a[2][0]==0){
        $a[2]=$a[2][1];
    }
    if($a[1][0]==0){
        $a[1]=$a[1][1];
    }
    if($date[0]==$today){
        return $hour;
    }else{
        $res = round((strtotime($today) - strtotime($date[0])) / 86400);
        if($res==1){
            return "wczoraj ".$hour;
        }else{
            if($a[0]==date('Y')){
                return $a[2].' '.$month_names[$a[1]];
            }else{
                return $a[2].' '.$month_names[$a[1]].' '.$a[0];
            }
        }

    }
}
function get_images($user,$gallery){
    if($gallery=='private'){
        $files = glob(GALLERY_PATH.'/'.$user.'/private/thumbnail/*.*');
    }else{
        $files = glob(GALLERY_PATH.'/'.$user.'/thumbnail/*.*');
    }
    $supported_format = array('gif','jpg','jpeg','png');
    $images=array();
    foreach ($files as $file){
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $supported_format))
        {
            array_push($images,$file);
        }
    }
    return $images;
}
function print_images($images,$delete=false){
    foreach ($images as $image){
        $to_remove=['lib/images/gallery/','/thumbnail'];
        $big_image=str_replace($to_remove,'',$image);
        echo '<div class="col-sm-2 col-xs-3 text-center preview">
              <a href="#" data-image="'.$big_image.'" class="img-prev" data-gallery><img src="'.$image.'" /></a>';
        if($delete){
            echo '<button class="delete" data-type="DELETE">
              <i class="fa fa-times" aria-hidden="true"></i>
              </button>';
        }
              echo '</div>';
    }
}

function no_permissions_gallery($wfa=false,$guest){
    $text='<div class="col-sm-2 lock">
          <img src="lib/images/lock.png" class="img-responsive">
          </div>
          <div class="col-sm-8">
          <p class="bold">Nie masz uprawnień do oglądania zdjęć z tej galerii</p>
          <p>Kliknij w poniższy przycisk, aby poprosić uzytkownika '.$_GET['name'].' o przyznanie dostępu do jej pikantnych zdjęć.</p>';
            if($wfa==false){
                $text.='<p><button class="btn btn-primary permissions_ask">Poproś o dostęp</button></p>';
            }else{
                $text.='<p class="alert-success alert">Wysłano prośbę o dostęp do galerii</p>';
            }

    $text.='</div>';
    $text.='<input type="hidden" name="guest" value="'.$guest.'">';
    $text.='<input type="hidden" name="owner" value="'.$_GET['name'].'">';
    echo $text;
}

function print_notification($type,$owner,$user,$role='user'){
    if($role=='fake'){
        $link='profile.php?name='.$user.'&ref_user='.$owner;
    }else{
        $link='profile.php?name='.$user;
    }
    switch ($type){
        case 1:
            $text='Użytkownik <a href="'.$link.'" target="_blank">'.$user.'</a> prosi o dostęp do prywatnej galerii';
            $text.='<form action="'.$_SERVER['REQUEST_URI'].'" class="permissions_answer">
                    <input type="hidden" name="user" value="'.$user.'">
                    <input type="hidden" name="owner" value="'.$owner.'">
                    <input type="hidden" name="type" value="'.$type.'">
                    <button class="btn btn-primary">Akceptuj</button>
                    <button class="btn btn-danger">Odrzuć</button>
                    </form>';
            break;
        case 2:
            $text='Użytkownik <a href="'.$link.'" target="_blank">'.$user.'</a> zaakceptował Twoją prośbę o dostęp do prywatnej galerii';
            break;
        case 3:
            $text='Użytkownik <a href="'.$link.'" target="_blank">'.$user.'</a> odrzucił Twoją prośbę o dostęp do prywatnej galerii';
            break;
        case 4:
            $text='Zaakceptowano prośbę użytkownika <a href="'.$link.'" target="_blank">'.$user.'</a> o dostęp do prywatnej galerii';
            break;
        case 5:
            $text='Odrzucono prośbę użytkownika <a href="'.$link.'" target="_blank">'.$user.'</a> o dostęp do prywatnej galerii';
            break;
        default:
            $text='';
            break;
    }
    return $text;
}
function jednostki($howmany){
    $arr=str_split((string)$howmany);
    if($howmany=='1'){
        $jed='zdjęcie';
    }else if(($arr[(sizeof($arr)-1)]>1)&&($arr[(sizeof($arr)-1)]<5)){
        if((sizeof($arr)==2)&&($arr[0]=='1')){
            $jed='zdjęć';
        }else{
            $jed='zdjęcia';
        }
    }else{
        $jed='zdjęć';
    }
    return $howmany.' '.$jed;
}

function is_vip($user,$con){
    $sql="SELECT account_type FROM users WHERE name='".$user."'";
    $res=$con->query($sql)->fetch_array()['account_type'];
    if($res==2){
        if($_SESSION['usr_name']==$user){
            $title='Posiadasz konto VIP';
        }else{
            $title='Ten użytkownik posiada konto VIP';
        }
        return '<span class="vip" title="'.$title.'"><i class="fa fa-trophy" aria-hidden="true"></i></span>';
    }
}
function coins_status($name,$con){
    $coins_table='account_coins';
    $coins_sql="SELECT coins FROM $coins_table WHERE login='".$name."'";
    return $con->query($coins_sql)->fetch_array()['coins'];
}

function send_message($from,$to,$message,$account_type,$message_price='20',$con){
    $table="messages";
    $sql = "INSERT INTO $table VALUES(NULL,'$from','$to','$message',NOW(),0)";
    if($account_type=='2'){
        if ($con->query($sql) === TRUE) {
            return true;
        }else{
            return false;
        }
    }else{
        $coin_table='account_coins';
        $coin_sql="UPDATE $coin_table SET coins=coins-".$message_price." WHERE login='".$from."'";
        if((coins_status($from,$con)>=$message_price)&&($con->query($sql)===TRUE)&&($con->query($coin_sql)===TRUE)){
            return true;
        }else{
            return false;
        }
    }
}
function user_profile($array){
    $class=($array['account_type']=='2')? 'vip' : 'standard';
    ?>
    <div class="col-md-4 col-xs-6 col-sm-6 profile <?php echo $class;?>">
        <a href="profile.php?name=<?php echo $array['name'];?>">
            <div class="thumbnail">
                <div class="photo">
                    <img src="<?php echo AVATAR_PATH.'/'.$array['avatar'];?>" alt="" class="img-responsive">
                </div>
                <div class="caption">
                    <h3><?php echo $array['name'].', '.$array['age'];?></h3>
                    <h4><?php echo $array['state'];?></h4>
                    <p><?php echo addDots($array['info'],100);?></p>
                 </div>
                <div class="buttons">
                    <a class="btn btn-primary" href="profile.php?name=<?php echo $array['name'];?>">Zobacz zdjęcia</a>
                    <a class="btn btn-default" href="message.php?with=<?php echo $array['name'];?>">Wyślij wiadomość</a>
                </div>
            </div>
        </a>
    </div>
<?php }
?>