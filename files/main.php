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

$result = $con->query($sql);
if(!isset($_GET['page']))
{
    $page=1;
}else{
    $page=$_GET['page'];
    if((($page-1)>ceil($result->num_rows/$config->getConfig()->profiles_per_page))||($page<1)){
        header("Location:index.php");
    }
}
if($_SESSION['account_type']=='2'){
    $prof_pp=$config->getConfig()->profiles_per_page;
}else{
    $prof_pp=$config->getConfig()->profiles_per_page-1;
}
$min=$prof_pp*($page-1);
$max=$prof_pp*$page;
$pages=ceil($result->num_rows/$prof_pp);
if($_SESSION['account_type']=='1'){
	if($page==10){
		$max-=1;
	}elseif($page>10){
		$page=10;
		$min=$prof_pp*($page-1);
		$max=$prof_pp*$page;
		$max-=1;
	}

	if($pages>$config->getConfig()->standard->max_pages){
		$pages=$config->getConfig()->standard->max_pages;
	}

}
?>
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
$number=0;
	if ($result->num_rows > 0) {
    while($profile = $result->fetch_assoc()) {
    	$number+=1;
	    	if(($number>$min)&&($number<=$max)) {
				user_profile($profile);
	    		 }
    }
		if(($_SESSION['account_type']=='1')&&($page==10)) {
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

} else {
    echo "Nie znaleziono profili odpowiadacych kryteriom wyszukiwania";
}
?>
    <div class="clearfix"></div>
</div>
<div class="col-sm-8 col-xs-12 col-xs-offset-0 col-sm-offset-2 text-center">
<ul class="pagination">
	<?php if($page>1){?>
	<li><a href="<?php echo $_SERVER['PHP_SELF'].'?page='.($page-1);?>">«</a></li>
	<?php }?>
<?php
			$range=$config->getConfig()->paginate_range;
			$initial_num = $page - $range;
			$condition_limit_num = ($page + $range)  + 2;

			for ($x=$initial_num; $x<$condition_limit_num; $x++) {

				// be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
				if (($x > 0) && ($x <= $pages)) {

					// current page
					if ($x == $page) {
						echo '<li class="active"><span>'.$x.'</span></li>';
					}

					// not current page
					else {
						echo '<li><a href="?page='.$x.'">'.$x.'</a></li>';
					}
				}
			}
		    if($page<$pages){?>
				<li><a href="<?php echo '?page='.($page+1);?>">»</a></li></ul>
			<?php }

?>

</div>