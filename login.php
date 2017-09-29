<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
    header("Location: index.php");
}

include_once 'conf/config.php';
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
    <?php include ('files/head.php');?>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="login_wrapper col-md-10 col-md-offset-1">
        <div class="col-md-5 well">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
                <fieldset>
                    <legend>Zaloguj się:</legend>
                    
                    <div class="form-group">
                        <label for="name">Adres Email</label>
                        <input type="text" name="email" placeholder="Adres Email" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="name">Hasło</label>
                        <input type="password" name="password" placeholder="Hasło" required class="form-control" />
                    </div>

                    <div class="form-group">
                        <input type="submit" name="login" value="Zaloguj się" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
        </div>
            <div class="clearfix"></div>
            <div class="col-md-12 login_footer">

            </div>
        </div>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>