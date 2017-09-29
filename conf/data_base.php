 <?php
if(($_SERVER['HTTP_HOST']=='localhost')||($_SERVER['SERVER_ADDR']=='127.0.0.1')||($_SERVER['HTTP_HOST']=='10.105.48.188')){

	$servername = $config->getConfig()->db->localhost->host;
	$username = $config->getConfig()->db->localhost->login;
	$password = $config->getConfig()->db->localhost->password;
	$dbase=$config->getConfig()->db->localhost->dbname;
}else{
	$servername = $config->getConfig()->db->online->host;
	$username = $config->getConfig()->db->online->login;
	$password = $config->getConfig()->db->online->password;
	$dbase=$config->getConfig()->db->online->dbname;
}
$con = new mysqli($servername, $username, $password,$dbase);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$con->set_charset("utf8mb4");
?> 