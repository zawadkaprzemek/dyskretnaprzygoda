<?php
if(isset($_GET['search'])){?>
<div class="search-results">
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
            user_profile($profile);
            ?>

        <?php } ?>
    <?php }else{ ?>
        <div class="col-sm-12"><p class="alert alert-info">Nie znaleziono żadnego użytkownika pasującego do podanej frazy:
                <?php echo
                $_GET['search']?></></div>
    <?php }
    ?>
        <div class="clearfix"></div>
    </div>

</div>
<?php }else{
    header("Location:index.php");
}
?>