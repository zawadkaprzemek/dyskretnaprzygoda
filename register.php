<?php
session_start();
include_once 'conf/config.php';
include_once 'conf/functions.php';
include_once 'conf/data_base.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_GET['signup'])) {
    $name = mysqli_real_escape_string($con, $_GET['name']);
    $email = mysqli_real_escape_string($con, $_GET['email']);
    $password = mysqli_real_escape_string($con, $_GET['password']);
    $cpassword = mysqli_real_escape_string($con, $_GET['rep_password']);
    
    //name can contain only alpha characters and space
    if (!preg_match("/^[A-Za-z0-9]+$/",$name)) {
        $error = true;
        $message ='{"status":"error","message":"Login może składać się tylko z liter i cyfr"}';
    }else{
        $sql="SELECT * FROM users WHERE name='$name'";
        $result = $con->query($sql);
        if ($result->num_rows>0) {
            $error = true;
            $message ='{"status":"error","message":"Username already exists."}';
        }
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $message ='{"status":"error","message":"E-mail address is invalid."}';
    }else{
        $sql="SELECT * FROM users WHERE email='$email'";
        $result = $con->query($sql);
        if ($result->num_rows>0) {
            $error = true;
            $message ='{"status":"error","message":"E-mail address is already in use."}';
        }
    }
    if(strlen($password) < 8) {
        $error = true;
        $message ='{"status":"error","message":"Hasło musi się składać conajmniej z 8 znaków"}';
    }
    if($password != $cpassword) {
        $error = true;
        $message ='{"status":"error","message":"Hasła nie są takie same"}';
    }
    if (!$error) {
        if(mysqli_query($con, "INSERT INTO users VALUES(NULL,'" . $name . "', '" . $email . "', '" . md5($password) . "','user',0)")) {
            $message ="Rejestracja zakończona sukcesem <a href='login.php'>Kliknij tutaj aby się zalogować</a>";
            $message ='{"status":"ok","message":"Rejestracja udana"}';
        } else {
            $message ='{"status":"error","message":"'.$con->error.'"}';
        }
    }
    echo $message;
}
?>