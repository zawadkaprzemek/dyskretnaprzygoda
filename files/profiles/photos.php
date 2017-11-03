<?php
if($_SESSION['usr_role']=='super_admin'){
$delete=true;
}else{
$delete=false;
}
$images=get_images($_GET['name'],'public');
$count=count($images);
?>
<div class="col-sm-12">
    <h2>Zdjęcia użytkownika</h2>
    <?php include('files/gallery.php')?>
    <div class="galleries panel panel-default">
        <div class="public-gallery">
            <div class="panel-heading">
                <h4 class="panel-title">Galeria publiczna <?php if($count>0){echo '<span>('.jednostki($count).')</span>';}?></h4>
            </div>
            <div class="panel-body">
                <?php
                if($count==0){
                    echo '<p>Użytkownik nie posiada jeszcze zdjęć w galerii</p>';
                }else{
                    print_images($images,$delete);
                }
                ?>
            </div>
        </div>
        <?php
        $images=get_images($_GET['name'],'private');
        $count=count($images,true);
        if(($count>0)||($_SESSION['usr_role']=='super_admin')){ ?>
        <div class="private-gallery">
            <div class="panel-heading">
                <h4 class="panel-title">Galeria prywatna <?php if($count>0){echo '<span>('.jednostki($count).')</span>';}?></h4>
            </div>
            <div class="panel-body">
                <?php
                if($_SESSION['usr_role']=='super_admin'){
                    $gall_perm=1;
                }else{
                    $perm_table='gallery_permissions';
                    $perm_sql="SELECT status FROM $perm_table WHERE (gallery_owner='".$_GET['name']."' AND user='".$_SESSION['usr_name']."')";
                    $perm=$con->query($perm_sql);
                    if ($perm->num_rows > 0){
                        while($data = $perm->fetch_assoc()) {
                            $gall_perm=$data['status'];
                            if($gall_perm==0){
                                $wfa=true;
                            }
                        }
                    }else{
                        $gall_perm=0;
                    }
                }
                if($count==0){
                    echo '<p>Użytkownik nie posiada jeszcze zdjęć w galerii</p>';
                }else{
                    if($gall_perm==1){
                        print_images($images,$delete);
                    }else{
                        no_permissions_gallery(@$wfa);
                    }
                }
                ?>
            </div>
        </div>
        <?php } ?>

    </div>
</div>
<?php
if(($_SESSION['usr_role']=='super_admin')&&($data['role']=='fake')){
    include(dirname(__FILE__).'/../my_profile/upload.php');
}
?>