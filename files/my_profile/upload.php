<?php
$action=$_SERVER['PHP_SELF'];
if($_SERVER['REQUEST_URI']!=$_SERVER['PHP_SELF']){
    $action.='?';
    if(isset($_GET['action'])||(isset($_GET['name']))){
        $action.=key($_GET).'='.$_GET[key($_GET)];
    }
}
?>

<div class="col-sm-12 upload">
    <form id="fileupload" action="<?php echo $action;?>" method="POST" enctype="multipart/form-data">
        <div class="row fileupload">
            <div class="col-lg-10">

                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Dodaj zdjęcia...</span>
                    <input type="file" name="files[]" id="addfiles" accept="image/*" multiple>
                </span>
                <input type="radio" id="public" name="gallery" value="public" checked>
                <label for="public">Publiczna galeria</label>
                <input type="radio" id="private" name="gallery" value="private">
                <label for="private">Prywatna galeria</label>
                <input type="hidden" value="ADD" name="method">
                <?php
                if(stristr($_SERVER['PHP_SELF'],'my_profile.php')=='my_profile.php'){
                    $user=$_SESSION['usr_name'];
                }else{
                    $user=$_GET['name'];
                }
                ?>
                <input type="hidden" value="<?php echo $user;?>" name="user">

            </div>
        </div>
    </form>
<div class="loading">
    <img src="lib/images/loading.gif" alt="">
</div>
</div>