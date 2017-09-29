<?php
session_start();

if(isset($_SESSION['usr_id'])) {
    header("Location: index.php");
}

include_once 'conf/config.php';
include_once 'conf/data_base.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    
    //name can contain only alpha characters and space
    if (!preg_match("/^[A-Za-z0-9]+$/",$name)) {
        $error = true;
        $name_error = "Login może składać się tylko z liter i cyfr";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Prosze wprowadzić właściwy adres email";
    }
    if(strlen($password) < 8) {
        $error = true;
        $password_error = "Hasło musi się składać conajmniej z 8 znaków";
    }
    if($password != $cpassword) {
        $error = true;
        $cpassword_error = "Hasła nie są takie same";
    }
    if (!$error) {
        if(mysqli_query($con, "INSERT INTO users(name,email,password,role) VALUES('" . $name . "', '" . $email . "', '" . md5($password) . "','user')")) {
            $successmsg = "Rejestracja zakończona sukcesem <a href='login.php'>Kliknij tutaj aby się zalogować</a>";
        } else {
            $errormsg = "Błąd podczas rejestracji... Spróbuj ponownie później!";
        }
    }
}
?>
<?php if($config->getConfig()->allow_register_page=="yes"){?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $config->getConfig()->name?> - Rejestracja</title>
    <?php include ('files/head.php');?>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                <fieldset>
                    <legend>Sign Up</legend>

                    <div class="form-group">
                        <label for="name">Login</label>
                        <input type="text" name="name" placeholder="Enter Full Name" required value="<?php if($error) echo $name; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" name="email" placeholder="Email" required value="<?php if($error) echo $email; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Hasło</label>
                        <input type="password" name="password" placeholder="Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Powtórz hasło</label>
                        <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="signup" value="Zarejstruj mnie" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
            <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
        </div>
    </div>
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php }else{
    header("Location:index.php");
}