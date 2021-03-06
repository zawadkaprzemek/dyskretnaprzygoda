<script type="text/javascript" src="lib/js/cropbox.js"></script>
<?php
if(isset($_POST['edit_profile'])){
    $errormsg='';
    if($_POST['avatar']!=''){
        $avatar=$_POST['avatar'];
        list($type, $avatar) = explode(';', $avatar);
        list(, $avatar)      = explode(',', $avatar);
        $avatar = base64_decode($avatar);
        $av_name=$_POST['user'].".png";
        $filepath = AVATAR_PATH."/".$av_name;
        if((file_put_contents($filepath,$avatar))&&($av_name!=$_POST['old_avatar'])&&($_POST['old_avatar']!='')){
            unlink(AVATAR_PATH.'/'.$_POST['old_avatar']);
        }
    }
    $table="users_info";
    $name = mysqli_real_escape_string($con, $_POST['user']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $info = mysqli_real_escape_string($con, $_POST['info']);
    $age = mysqli_real_escape_string($con, $_POST['age']);

    if($_POST['avatar']!=''){
        $sql="UPDATE $table SET avatar='$av_name',age='$age', state='$state',info='$info' WHERE user_name='$name'";
    }else{
        $sql="UPDATE $table SET age='$age',state='$state',info='$info' WHERE user_name='$name'";
    }
    if ($con->query($sql) === TRUE) {
        header("Location:profile.php?name=".$name);
    } else {
        $errormsg.= "Error: " . $con->error.'<br>';
    }

}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $("#date_birth" ).datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate:"-18Y",
            changeMonth: true,
            changeYear: true,
            showOn: "both",
            buttonImage: "css/calendar.gif",
            buttonImageOnly: true,
            buttonText: "Wybierz datę urodzenia"
        });
    });
</script>
<?php
$table="users_info";
$table2="users";
$user=$_GET['name'];
$sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_name=$table2.name WHERE user_name='$user'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while($data = $result->fetch_assoc()) {
        if($data['role']=='super_admin'){
            header("Location:index.php");
        }
        $state=$data['state'];
        $info=$data['info'];
        $age=$data['age'];
        $sex=$data['sex'];
        $avatar=$data['avatar'];
    }
}else{
    $state='';
    $info='';
    $avatar='';
}
?>
<div class="form_container">
    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=edit" method="post" name="editprofileform" id="editprofileform" enctype="multipart/form-data">
        <div class="col-sm-12"><h3>Edytuj profil</h3></div>
        <div class="form-group col-sm-8 col-md-8">
            <label for="state">Stan cywilny:</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo $state;?>" required>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-8">
            <label for="info">O mnie:</label>
            <textarea class="form-control col-sm-8" name="info" id="info" required><?php echo $info;?></textarea>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-sm-12 cropbox-container">
            <label for="file">Avatar:</label>
            <div class="imageBox">
                <div class="thumbBox"></div>
                <div class="spinner" style="display: none">Loading...</div>
            </div>
            <div class="action row">
                <div class="col-xs-5">
                <span class="btn btn-primary fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Wybierz zdjęcie...</span>
                    <input type="file" name="file" id="file" accept="image/*" <?php if($avatar==''){echo "required";}?>>
                </span>
                    <p class="help-block hidden">Plik musi być zdjęciem i nie może zajmować więcej niż 2MB</p>
                </div>
                <div class="col-xs-7">
                    <input type="button" id="btnCrop" class="btn btn-default crop" value="Ustaw jako avatar">
                    <input type="button" id="btnZoomIn" class="btn btn-default resize" value="+">
                    <input type="button" id="btnZoomOut" class="btn btn-default resize" value="-">
                </div>
                <div class="clearfix"></div>
                <p class="help-block">Plik musi być zdjęciem i nie może zajmować więcej niż 2MB</p>
            </div>
            <div style="display: none;">
                <input type="hidden" name="avatar" id="avatar" value="">
                <input type="hidden" name="old_avatar" id="old_avatar" value="<?php echo $avatar;?>">
            </div>
        </div>
        <div class="col-sm-12 hidden">
            <p class="bold">Podgląd:</p>
            <div class="cropped">
                <?php if($avatar!=''){?>
                    <img src="<?php echo AVATAR_PATH.'/'.$avatar?>" class="img-responsive">
                <?php } ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php if(!isset($sex)){?>
            <div class="radio col-sm-8">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input type="radio" name="sex" value="w" required> <i class="fa fa-female" aria-hidden="true"> Kobieta</i>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="sex" value="m" required> <i class="fa fa-male" aria-hidden="true"> Mężczyzna</i>
                    </label>
                </div>
            </div>
        <?php }?>
        <div class="clearfix"></div>
            <div class="form-group col-sm-6">
                <label for="age">Wiek:</label>
                <p><input type="text" class="form-control" id="age" name="age" value="<?php echo $age?>" required></p>
            </div>
        <div class="clearfix"></div>
        <div class="col-sm-8">
            <input type="hidden" name="user" id="user" value="<?php echo $_GET['name']?>" />
            <input type="submit" name="edit_profile" class="btn btn-default" value="Zapisz zmiany" />
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
            imgSrc: '<?php echo AVATAR_PATH.'/'.$avatar;?>'
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
