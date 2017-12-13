<?php
if(isset($_GET['search'])){?>
<div class="col-sm-12 search-results">
    <div class="col-sm-12"><h3>Wyniki wyszukiwania "<?php echo $_GET['search']?>":</h3></div>
    <div class="text-center profile_list">
    <?php
    $table='users';
    $table2="users_info";
    $sql="SELECT * FROM $table INNER JOIN $table2 ON $table.name=$table2.user_name WHERE $table.name LIKE '%".$_GET['search']."%'";
    if($config->getConfig()->display_true_users=='yes'){
        $sql.=" AND role!='super_admin";
    }else{
        $sql.=" AND role='fake'";
    }
    $sql.=" ORDER BY $table.name";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {?>
        <?php while($profile = $result->fetch_assoc()) {
            if ($profile['account_type'] == '2') {
                $class = 'vip';
            } else {
                $class = 'standard';
            }
            ?>
            <div class="col-md-4 col-sm-6 profile <?php echo $class;?>">
                <a href="profile.php?name=<?php echo $profile['user_name'];?>">
                    <div class="thumbnail">
                        <div class="photo">
                            <img src="<?php echo AVATAR_PATH.'/'.$profile['avatar'];?>" alt="" class="thumbnail-photo">
                        </div>
                        <div class="caption">
                            <h3><?php echo $profile['user_name'].', '.$profile['age'];?></h3>
                            <h4><?php echo $profile['state'];?></h4>
                            <p class="ellipsis"><?php echo addDots($profile['info'],100);?></p>
                            <div class="buttons">
                                <a class="btn btn-primary" href="profile.php?name=<?php echo $profile['user_name'];?>">Zobacz zdjęcia</a>
                                <a class="btn btn-default" href="message.php?with=<?php echo $profile['user_name'];?>">Wyślij wiadomość</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div></a>
            </div>

        <?php } ?>
    <?php }else{ ?>
        <div class="col-sm-12"><p class="alert alert-info">Nie znaleziono żadnego użytkownika pasującego do podanej frazy:
                <?php echo
                $_GET['search']?></></div>
    <?php }
    ?>

    </div>
</div>
<?php }else{
    header("Location:index.php");
}
?>