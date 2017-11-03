<?php
define("AVATAR_PATH",'lib/images/avatars');
define("GALLERY_PATH",'lib/images/gallery');
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
        echo '<div class="col-sm-2 text-center preview">
              <a href="#" data-image="'.$big_image.'" class="img-prev" data-gallery><img src="'.$image.'" /></a>';
        if($delete){
            echo '<button class="delete" data-type="DELETE">
              <i class="fa fa-times" aria-hidden="true"></i>
              </button>';
        }
              echo '</div>';
    }
}

function no_permissions_gallery($wfa=false){
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
    $text.='<input type="hidden" name="user" value="'.$_SESSION['usr_name'].'">';
    $text.='<input type="hidden" name="owner" value="'.$_GET['name'].'">';
    echo $text;
}

function print_notification($type,$owner,$user){
    switch ($type){
        case 1:
            $text='Użytkownik <a href="profile.php?name='.$user.'" target="_blank">'.$user.'</a> prosi o dostęp do prywatnej galerii';
            $text.='<form action="'.$_SERVER['REQUEST_URI'].'" class="permissions_answer">
                    <input type="hidden" name="user" value="'.$user.'">
                    <input type="hidden" name="owner" value="'.$owner.'">
                    <input type="hidden" name="type" value="'.$type.'">
                    <button class="btn btn-primary">Akceptuj</button>
                    <button class="btn btn-danger">Odrzuć</button>
                    </form>';
            break;
        case 2:
            $text='Użytkownik <a href="profile.php?name='.$user.'" target="_blank">'.$user.'</a> zaakceptował Twoją prośbę o dostęp do prywatnej galerii';
            break;
        case 3:
            $text='Użytkownik <a href="profile.php?name='.$user.'" target="_blank">'.$user.'</a> odrzucił Twoją prośbę o dostęp do prywatnej galerii';
            break;
        case 4:
            $text='Zaakceptowano prośbę użytkownika <a href="profile.php?name='.$user.'" target="_blank">'.$user.'</a> o dostęp do prywatnej galerii';
            break;
        case 5:
            $text='Odrzucono prośbę użytkownika <a href="profile.php?name='.$user.'" target="_blank">'.$user.'</a> o dostęp do prywatnej galerii';
            break;
        default:
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
?>