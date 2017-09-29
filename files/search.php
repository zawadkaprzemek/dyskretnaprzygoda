<?php
if(isset($_GET['search'])){?>
<div class="col-sm-12 search-results">
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
        <div class="col-sm-12"><h2>Wyniki wyszukiwania <?php echo $_GET['search']?>:</h2></div>
        <?php while($data = $result->fetch_assoc()) {?>
            <a href="profile.php?name=<?php echo $data['name'];?>">
            <div class="col-sm-2">
                <img src="<?php echo AVATAR_PATH.'/'.$data['avatar'];?>" alt="<?php echo $data['name']?>" class="img-rounded">
            </div>
            <div class="col-sm-4">
            <?php echo $data['name'];?>
            </div>
            </a>

        <?php } ?>
    <?php }else{ ?>
        <div class="col-sm-12"><h3>Nie znaleziono żadnego użytkownika pasującego do podanej frazy: <?php echo $_GET['search']?></h3></div>
    <?php }
    ?>


</div>
<?php }else{
    header("Location:index.php");
}
?>