<?php
include ('conf/config.php');
echo $data = $_POST['base64'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);
$filepath = AVATAR_PATH."/image.png"; // or image.jpg
file_put_contents($filepath,$data);


if(isset($_POST['edit_profile'])){
    $errormsg='';
    if((isset($_FILES['avatar']["name"]))&&($_FILES['avatar']["name"]!='')){
        $target_dir="static/avatars/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errormsg.= "Wybrany plik nie jest zdjęciem<br>";
            $uploadOk = 0;
        }
        if ($_FILES["avatar"]["size"] > 500000) {
            $errormsg.= "Wybrany plik jest za duży<br>";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $errormsg.="Nie właściwy format pliku<br>";
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {

        } else {
            $newname=$_SESSION['usr_name'].'.'.$imageFileType;
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir.$newname)) {
                if(($_POST['old_avatar']!=$newname)&&($_POST['old_avatar']!='')) {
                    unlink($target_dir . $_POST['old_avatar']);
                    unset($_FILES['avatar']);
                }
                $table="users_info";
                $name = mysqli_real_escape_string($con, $_POST['user']);
                $state = mysqli_real_escape_string($con, $_POST['state']);
                $info = mysqli_real_escape_string($con, $_POST['info']);
                if(isset($_POST['sex'])) {
                    $sex = mysqli_real_escape_string($con, $_POST['sex']);
                }
                $date_birth = mysqli_real_escape_string($con, $_POST['date_birth']);
                $info_exist="SELECT * FROM $table WHERE user_name='$name'";
                if($con->query($info_exist)->num_rows==0){
                    $sql="INSERT INTO $table VALUES (NULL,'$name',NULL,'$newname','$state','$info','$sex','$date_birth')";
                    if ($con->query($sql) === TRUE) {
                        header("Location:my_profile.php");
                    } else {
                        $errormsg.= 'Error: '. $con->error.'<br>';
                    }
                }else{
                    $sql="UPDATE $table SET avatar='$newname', state='$state',info='$info' WHERE user_name='$name'";
                    if ($con->query($sql) === TRUE) {
                        header("Location:my_profile.php");
                    } else {
                        $errormsg.= "Error: " . $con->error.'<br>';
                    }
                }
            } else {
                $errormsg.= "Wystąpił błąd przy wgrywaniu pliku na serwer<br>";
            }
        }
    }else{
        $table="users_info";
        $name = mysqli_real_escape_string($con, $_POST['user']);
        $state = mysqli_real_escape_string($con, $_POST['state']);
        $info = mysqli_real_escape_string($con, $_POST['info']);
        $date_birth = mysqli_real_escape_string($con, $_POST['date_birth']);
        $sql="UPDATE $table SET state='$state',info='$info' WHERE user_name='$name'";
        if ($con->query($sql) === TRUE) {
            header("Location:my_profile.php");
        } else {
            $errormsg.= "Error: " . $con->error.'<br>';
        }
    }


}

?>


