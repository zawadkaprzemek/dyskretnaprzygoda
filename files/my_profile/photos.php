<div class="col-sm-12">
    <h4>Moje zdjęcia</h4>
    <?php
    if((isset($_GET['success']))||(isset($_GET['fail']))){
        if(@$_GET['success']>0){?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Dodano <?php echo $_GET['success'];?> zdjęć do Twojej galerii
            </div>
        <?php }else{?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Nie udało się dodać wybranych zdjęć do galerii
            </div>
        <?php }
    }
    $images=get_images($_SESSION['usr_name'],'public');
    $count=count($images);
    ?>
    <?php include('files/gallery.php')?>
    <div class="galleries panel panel-default">
        <div class="public-gallery">
        <div class="panel-heading">
        <h4 class="panel-title">Galeria publiczna <?php if($count>0){echo '<span>('.jednostki($count).')</span>';}?></h4>
        </div>
            <div class="panel-body">
        <?php
        if($count==0){
            echo '<p>Nie posiadasz jeszcze żadnych zdjęć w galerii, <label for="addfiles">dodaj je</label> teraz aby bardziej przyciągnąć do siebie randkowiczów</p>';
        }else{
            print_images($images,true);
        }
        ?>
            </div>
        </div>
        <?php
        $images=get_images($_SESSION['usr_name'],'private');
        $count=count($images,true);
        ?>
        <div class="private-gallery">
        <div class="panel-heading">
            <h4 class="panel-title">Galeria prywatna <?php if($count>0){echo '<span>('.jednostki($count).')</span>';}?></h4>
        </div>
            <div class="panel-body">
            <?php
            if($count==0){
                echo '<p>Nie posiadasz jeszcze żadnych zdjęć w galerii, <label for="addfiles">dodaj je</label> teraz aby bardziej przyciągnąć do siebie randkowiczów</p>';
            }else{
                print_images($images,true);
            }
            ?>
            </div>
        </div>
    </div>
</div>
<?php include ('upload.php');?>