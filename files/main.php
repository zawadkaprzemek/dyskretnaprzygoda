<div class="text-center profile_list">
	<?php
	if($_SESSION['account_type']=='1') {
		?>
		<div class="col-md-4 col-sm-6 profile buy_points list-unstyled">
			<div class="thumbnail">
				<p>Twoje konto: STANDARD</p>
				<h3>Zmień konto na VIP</h3>
				<ul>
					<li><i class="fa fa-check" aria-hidden="true"></i>nieograniczone wiadomości</li>
					<li><i class="fa fa-check" aria-hidden="true"></i>dostęp do pełnej bazy użytkowników</li>
					<li><i class="fa fa-check" aria-hidden="true"></i>baza seks-filmów użytkowniczek</li>
				</ul>
				<p>Kliknij w przycisk poniżej i raz na zawsze zmień swoje konto na VIP teraz:</p>
				<a href="doladuj.php"><button class="btn btn-info">Zmień konto na VIP</button></a>
			</div>
		</div>
<?php
	}
$table="users_info";
$table2="users";
$sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_name=$table2.name ";
//$sql="SELECT * FROM $table WHERE $table.user_name IN (SELECT user_name FROM $table2 WHERE role='fake') LIMIT 0,11";
if($config->getConfig()->display_fake=='yes'){
    if($config->getConfig()->display_true_users=='yes'){
         $sql.="WHERE (role='fake' OR role='user')";
    }else{
		$sql.="WHERE role='fake'";
    }
}else{
	$sql.="WHERE role='user'";
}

$result = $con->query($sql);
if(!isset($_GET['page']))
{
	$page=1;
}else{
	$page=$_GET['page'];
	if((($page-1)>$result->num_rows/$config->getConfig()->profiles_per_page)||($page<1)){
		header("Location:index.php");
	}
}
if($_SESSION['account_type']=='1'){
	$prof_pp=$config->getConfig()->profiles_per_page;
}else{
	$prof_pp=$config->getConfig()->profiles_per_page+1;
}
$min=$prof_pp*($page-1);
$max=$prof_pp*$page;
$number=0;
	if ($result->num_rows > 0) {
    while($profile = $result->fetch_assoc()) {
    	$number+=1;
	    	if(($number>$min)&&($number<=$max)) {
	    		if($profile['account_type']=='2'){
	    			$class='vip';
				}else{
					$class='standard';
				}
	    		?>
	    		<div class="col-md-4 col-sm-6 profile <?php echo $class;?>">
				<a href="profile.php?name=<?php echo $profile['name'];?>">
				<div class="thumbnail">
					<div class="photo">
					 <img src="<?php echo AVATAR_PATH.'/'.$profile['avatar'];?>" alt="" class="thumbnail-photo">
					 </div>
					<div class="caption">
						<h3><?php echo $profile['name'].', '.$profile['age'];?></h3>
						<h4><?php echo $profile['state'];?></h4>
						<p class="ellipsis"><?php echo addDots($profile['info'],100);?></p>
						<div class="buttons">
							 <a class="btn btn-primary" href="profile.php?name=<?php echo $profile['name'];?>">Zobacz zdjęcia</a>
							 <a class="btn btn-default" href="message.php?with=<?php echo $profile['name'];?>">Wyślij wiadomość</a>
						</div>
						<div class="clearfix"></div>
					</div>
				</div></a>
			</div>

			<?php }
    }

} else {
    echo "Nie znaleziono profili odpowiadacych kryteriom wyszukiwania";
}
?>
</div>
<div class="col-sm-6 col-sm-offset-3 text-center">
<ul class="pagination">
	<?php if($page>1){?>
	<li><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page-1);?>">«</a></li>
	<?php }?>
<?php
		    for ($i=0; $i<$result->num_rows/$prof_pp; $i++) {
		    		if($i==($page-1)){
		    			echo '<li class="active"><a href="#">'.($i+1).'</a></li>';
		    		}else{
		    			echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.($i+1).'">'.($i+1).'</a></li>';
		    		} 
		    }
		    if($page<$result->num_rows/$prof_pp){?>
				<li><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page+1);?>">»</a></li></ul>
			<?php }
?>

</div>