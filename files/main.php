<div class="text-center testim">
<?php
$table="users_info";
$table2="users";
$sql="SELECT * FROM $table INNER JOIN $table2 ON $table.user_name=$table2.name ";
if($config->getConfig()->display_fake=='yes'){
    if($config->getConfig()->display_true_users=='yes'){
         $sql.="WHERE (role='fake' OR role='user')";
    }else{
		$sql.="WHERE role='fake'";
    }
}else{
	$sql.="WHERE role='user'";
}
/*$sql2="SELECT * FROM users_info WHERE user_name='".$_SESSION['usr_name']."'";
$info_exist = $con->query($sql2);
if ($info_exist->num_rows > 0) {
	while($profile = $info_exist->fetch_assoc()) {
			$sql.=" AND sex!='".$profile['sex']."'";
	}
}*/
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
$min=$config->getConfig()->profiles_per_page*($page-1);
$max=$config->getConfig()->profiles_per_page*$page;
$number=0;
	if ($result->num_rows > 0) {
    while($profile = $result->fetch_assoc()) {
    	$number+=1;
	    	if(($number>$min)&&($number<=$max)) {
	    		?>
	    		<div class="col-md-4 col-sm-6 profile">
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
		    for ($i=0; $i<$result->num_rows/$config->getConfig()->profiles_per_page; $i++) {
		    		if($i==($page-1)){
		    			echo '<li class="active"><a href="#">'.($i+1).'</a></li>';
		    		}else{
		    			echo '<li><a href="'.$_SERVER['PHP_SELF'].'?page='.($i+1).'">'.($i+1).'</a></li>';
		    		} 
		    }
		    if($page<$result->num_rows/$config->getConfig()->profiles_per_page){?>
				<li><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page+1);?>">»</a></li></ul>
			<?php }
?>

</div>