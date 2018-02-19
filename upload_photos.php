<?php include_once ('files/headers.php');?>
<?php session_start();
define("GALERY_PATH",'lib/images/gallery');
define("MAXWIDTH",800);
define("MAXHEIGHT",800);
define("THUMBWIDTH",100);
define("THUMBHEIGHT",100);
$success=0;
$fail=0;


if($_REQUEST['method']=='ADD'){
    if($_REQUEST['gallery']=='private'){
        $path_to_gal=GALERY_PATH.'/'.strtolower($_REQUEST['user']).'/private';
    }else{
        $path_to_gal=GALERY_PATH.'/'.strtolower($_REQUEST['user']);
    }
    $path=realpath($path_to_gal);
    $thumbpath=realpath($path_to_gal.'/thumbnail');
    if($path === false AND !is_dir($path)){
        mkdir($path_to_gal,0777,true);
        mkdir($path_to_gal.'/thumbnail',0777,true);
        $path=realpath($path_to_gal);
        $thumbpath=realpath($path_to_gal.'/thumbnail');
    }
    foreach ($_FILES['files']['name'] as $i => $name) {
        if (strlen($_FILES['files']['name'][$i]) > 1) {
            try{
                $file=$_FILES['files']['tmp_name'][$i];
                $type = strtolower(substr(strrchr($_FILES['files']['name'][$i], '.'), 1));
                switch ($type){
                    case 'jpg':
                    case 'jpeg':
                        $fun = 'imagecreatefromjpeg';
                        $write_func = 'imagejpeg';
                        $quality=80;
                        break;
                    case 'png':
                        $fun = 'imagecreatefrompng';
                        $write_func = 'imagepng';
                        $quality=9;
                        break;
                    case 'gif':
                        $img= 'imagecreatefromgif';
                        $write_func = 'imagegif';
                        break;
                    default:
                        return false;
                }
                $img=$fun($file);
                $width  = imagesx($img);
                $height = imagesy($img);
                $scale = min(
                    MAXWIDTH / $width,
                    MAXHEIGHT / $height
                );
                $thumbproc=min(
                    THUMBWIDTH/$width,
                    THUMBHEIGHT/$height
                    );
                if($scale<1){
                    $proc=$scale;
                }else{
                    $proc=1;
                }
                    $width_new=$width*$proc;
                    $height_new=$height*$proc;
                    $width_thumb=$width*$thumbproc;
                    $height_thumb=$height*$thumbproc;
                    $new_image=imagecreatetruecolor($width_new, $height_new);
                    $thumb_image=imagecreatetruecolor($width_thumb, $height_thumb);
                    if($write_func=='imagepng'){
                        imagesavealpha($new_image, true);
                        imagesavealpha($thumb_image, true);
                        $color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                        $colorthumb = imagecolorallocatealpha($thumb_image, 0, 0, 0, 127);
                        imagefill($new_image, 0, 0, $color);
                        imagefill($thumb_image, 0, 0, $colorthumb);
                    }
                    imagecopyresampled($new_image, $img, 0, 0, 0, 0, $width_new , $height_new, $width  , $height);
                    $write_func($new_image, $path.'/'.$name, $quality);
                    imagecopyresampled($thumb_image, $new_image, 0, 0, 0, 0, $width_thumb , $height_thumb, $width_new  , $height_new);
                    $write_func($thumb_image, $thumbpath.'/'.$name, $quality);
                $success++;
            }catch (Exception $e){
                $fail++;
            }
        }
    }
}
if($_REQUEST['method']=='DELETE'){
    $arr= explode('/',$_REQUEST['image']);
    $image=$arr[(sizeof($arr)-1)];
    $gal=($_REQUEST['gallery']=='private'? $_REQUEST['gallery']:'');
    $image_path=realpath(GALERY_PATH.'/'.strtolower($_REQUEST['user']).'/'.$gal.'/'.$image);
    $thumb_path=realpath(GALERY_PATH.'/'.strtolower($_REQUEST['user']).'/'.$gal.'/thumbnail/'.$image);

    if((unlink($image_path))&&(unlink($thumb_path))){
        $success++;
    }else{
        $fail++;
    }
}
$result=array('success'=>$success,'fail'=>$fail);
echo json_encode($result);

