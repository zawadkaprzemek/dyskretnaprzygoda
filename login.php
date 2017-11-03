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
    <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/css/login.css">
    <script type="text/javascript" src="lib/js/jquery.js"></script>
    <script type="text/javascript" src="lib/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="col-md-10 well col-md-offset-1">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                <fieldset>
                    <legend>Zaloguj się:</legend>
                    <hr>
                    <div class="form-group">
                        <label for="name">Adres Email</label>
                        <input type="text" name="email" placeholder="Adres Email" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="name">Hasło</label>
                        <input type="password" name="password" placeholder="Hasło" required class="form-control" />
                    </div>
                    <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
                    <div class="form-group">
                        <input type="submit" name="login" value="Zaloguj się" class="btn" />
                    </div>
                </fieldset>
            </form>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<footer class="container-fluid">
    <div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6 col-sm-offset-3 text-center">
            <img src="lib/images/ico_1.png" alt="">
            <img src="lib/images/ico_2.png" alt="">
            <img src="lib/images/ico_3.png" alt="">
        </div>
    </div>
    </div>
</footer>
</body>
</html>