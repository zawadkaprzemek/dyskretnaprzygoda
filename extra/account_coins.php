<?php
include_once (dirname(__FILE__).'/../conf/config.php');
include_once '../conf/functions.php';
include_once '../conf/data_base.php';
session_start();
if(@$_SESSION['usr_role']=='super_admin') {
    $table = 'users';
    $sql = "SELECT name FROM $table WHERE role='user'";
    function insert($name)
    {
        $table2 = 'account_coins';
        return "INSERT INTO $table2 VALUES ('" . $name . "','400')";
    }

    $result = $con->query($sql);
    while ($data = $result->fetch_array()) {
        try {
            $sql2 = insert($data['name']);
            $stmt = $con->prepare($sql2);
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}