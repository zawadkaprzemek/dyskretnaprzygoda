<?php
$table="notifications";
$sql="SELECT count(id) as ile FROM $table WHERE (user_to='".$_SESSION['usr_name']."' AND status='0')";
$count=$con->query($sql);
$ile=$count->fetch_assoc()['ile'];
if($_SESSION['usr_role']=='super_admin'){
    $table2="users";
    $sql2="SELECT count($table.id) as ile FROM $table WHERE (user_to IN (SELECT $table2.name FROM $table2 WHERE role='fake') AND status='0')";
    $count=$con->query($sql2);
    $ile_fake=$count->fetch_assoc()['ile'];
}
?>
<header class="navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-8">
                    <form class="navbar-form navbar-left" role="search" action="search.php">
                        <div class="form-group">
                        <input type="text" name="search" id="search" class="form-control" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>" placeholder="Szukaj..." required>
                        </div>
                    </form>
                </div>
                <div class="col-sm-4 text-right">
                    <div>
                        <a href="my_profile.php?action=notifications" class="notification user" title="Powiadomienia">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <?php
                            if($ile>0){
                              echo '<span>'.$ile.'</span>';
                            }
                            ?>
                        </a>
                        <?php
                        if($_SESSION['usr_role']=='super_admin'){?>
                            <a href="users.php?action=notifications" class="notification fake" title="Powiadomienia użytkowników">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <?php
                                if($ile_fake>0){
                                    echo '<span>'.$ile_fake.'</span>';
                                }
                                ?>
                            </a>
                        <?php }?>
                        <a href="logout.php" title="Wyloguj">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>