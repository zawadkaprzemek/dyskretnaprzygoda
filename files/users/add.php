<script type="text/javascript" src="lib/js/cropbox.js"></script>
<?php
$errormsg= "";
if(isset($_POST['add_profile'])){
    $login=mysqli_real_escape_string($con,$_POST['login']);
    $state=mysqli_real_escape_string($con,$_POST['state']);
    $age=mysqli_real_escape_string($con,$_POST['age']);
    $info=mysqli_real_escape_string($con,$_POST['info']);
    $sex=mysqli_real_escape_string($con,$_POST['sex']);
    $table='users';
    $mail=$login.'@fmail.com';
    $pass=md5($login.'.jpg');
    $sql="INSERT INTO $table VALUES(NULL,'$login','$mail','$pass','fake','1')";
    if ($con->query($sql) === TRUE) {
        $avatar=$_POST['avatar'];
        list($type, $avatar) = explode(';', $avatar);
        list(, $avatar)      = explode(',', $avatar);
        $avatar = base64_decode($avatar);
        $av_name=$login.".png";
        $filepath = AVATAR_PATH."/".$av_name;
        if(file_put_contents($filepath,$avatar)){
            $table2='users_info';
            $wiek=str_split((string)$age);
            if(($wiek[1]>1)&&($wiek[1]<5)){
                $age=$age.' lata';
            }else{
                $age=$age.' lat';
            }
            $sql2="INSERT INTO $table2 VALUES('$login','$age','$av_name','$state','$info','$sex',NULL)";
            if ($con->query($sql2) === TRUE) {
                header('Location:profile.php?name='.$login);
            }else{
                $errormsg.= "Error: " . $con->error.'<br>';
            }
        }
    }else{
        $errormsg.= "Error: " . $con->error.'<br>';
    }
}else{
    $login=$state=$info='';
    $age=18;
}
?>
<div class="form_container col-sm-12">
    <?php echo $errormsg;?>
    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=add" method="post" name="addprofileform" id="addprofileform" enctype="multipart/form-data">
        <h2>Dodaj nowego użytkownika</h2>
        <div class="form-group col-sm-6">
            <label for="state">Login:</label>
            <input type="text" class="form-control" id="login" name="login" value="<?php echo $login?>" required>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-6">
            <label for="state">Stan cywilny:</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo $state?>" required>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-8">
            <label for="info">O mnie:</label>
            <textarea class="form-control col-sm-8" name="info" id="info" placeholder="..." required><?php echo $info?></textarea>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-8 cropbox-container">
            <label for="file">Avatar:</label>
            <div class="imageBox">
                <div class="thumbBox"></div>
                <div class="spinner" style="display: none">Loading...</div>
            </div>
            <div class="action">
                <input type="button" id="btnCrop" class="btn btn-default" value="Ustaw jako avatar">
                <input type="button" id="btnZoomIn" class="btn btn-default" value="+">
                <input type="button" id="btnZoomOut" class="btn btn-default" value="-">
                <input type="file" id="file" name="file" accept="image/*" required>
                <div class="clearfix"></div>
                <p class="help-block">Plik musi być zdjęciem i nie może zajmować więcej niż 500KB</p>
            </div>
            <div style="display: none;">
                <input type="hidden" name="avatar" id="avatar" value="">
            </div>
        </div>
        <div class="col-sm-4">
            <p class="bold">Podgląd:</p>
            <div class="cropped">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="radio col-sm-8">
            <label><input type="radio" name="sex" value="w" required><i class="fa fa-female" aria-hidden="true"> Kobieta</i>
            </label>
            <label><input type="radio" name="sex" value="m" required><i class="fa fa-male" aria-hidden="true"> Mężczyzna</i>
            </label>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-6">
            <label for="date_birth">Wiek:</label>
            <p><input type="number" class="form-control" id="age" name="age" value="<?php echo $age?>" required></p>
        </div>
        <div class="clearfix"></div>
        <div class="col-sm-8">
        <input type="submit" name="add_profile" class="btn btn-default" value="Dodaj nowego użytkownika" />
        </div>
        <div class="clearfix"></div>
    </form>
    <div class="col-sm-8">
    <p>
    <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
    </p>
    </div>
</div>


<script type="text/javascript">
    window.onload = function() {
        var options =
        {
            imageBox: '.imageBox',
            thumbBox: '.thumbBox',
            spinner: '.spinner',
            imgSrc: ''
        }
        var cropper = new cropbox(options);
        document.querySelector('#file').addEventListener('change', function(){
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = new cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            this.files = [];
        })
        document.querySelector('#btnCrop').addEventListener('click', function(){
            var img = cropper.getDataURL();
            document.querySelector('.cropped').innerHTML = '<img src="'+img+'" class="img-responsive">';
            document.getElementById('avatar').value=img;
        })
        document.querySelector('#btnZoomIn').addEventListener('click', function(){
            cropper.zoomIn();
        })
        document.querySelector('#btnZoomOut').addEventListener('click', function(){
            cropper.zoomOut();
        })
    };
</script>
