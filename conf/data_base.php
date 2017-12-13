 <?php
if(($_SERVER['HTTP_HOST']=='localhost')||($_SERVER['SERVER_ADDR']=='127.0.0.1')||($_SERVER['HTTP_HOST']=='10.105.48.188')||($_SERVER['HTTP_HOST']=='10.110.248.2')){
	$arr=array(
		"dbname"=>"dyskretna_online",
	  	"host"=>"localhost",
	  	"login"=>"root",
	  	"password"=>"kisiello1989"
	);
}else{
	$arr=array(
		"dbname"=>"www",
  		"host"=>"localhost",
	  	"login"=>"www",
	  	"password"=>"GmSnfAzu"
	);
}
$servername = $arr["host"];
$username = $arr["login"];
$password = $arr["password"];
$dbase = $arr["dbname"];
$con = new mysqli($servername, $username, $password,$dbase);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$con->set_charset("utf8mb4");
?> 