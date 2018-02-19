<?php include_once ('files/headers.php');?>
<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
    header("Location: index.php");
}

include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';

//check if form is submitted
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "' and password = '" . md5($password) . "'");
    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['usr_id'] = $row['id'];
        $_SESSION['usr_name'] = $row['name'];
        $_SESSION['usr_role'] = $row['role'];
        $_SESSION['activate'] = $row['activate'];
        $_SESSION['account_type'] = $row['account_type'];
        header("Location: index.php");
    } else {
        $errormsg = "Niewłaściwy adres Email lub hasło!!!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $config->getConfig()->name?> - Logowanie</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/login.css">
    <script type="text/javascript" src="lib/js/jquery.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 login_page">
            <div class="col-sm-12 white_bg">
                <div class="col-sm-12 girl_bg">
                    <div class="col-sm-5 col-xs-8 text-center white_bg">
                        <img src="lib/images/logo1.jpg" alt="<?php echo $config->getConfig()->name?>" class="img-responsive">
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Adres Email" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Hasło" required class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="login" value="Zaloguj się" class="btn btn-default
                                    btn-lg btn-block" />
                                </div>
                                <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?>&nbsp;
                                </span>
                            </fieldset>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-5 col-xs-8 only_text text-center">
                        <p>Ponad <span>44540</span> anonimowych użytkowników!</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-sm-12 logotypes text-center">
                    <img src="lib/images/logotypes.jpg" class="img-responsive">
                </div>
                <div class="col-sm-12 text-center service_name">
                    <p><?php echo $config->getConfig()->name?> - <?php echo $_SERVER['HTTP_HOST']?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>