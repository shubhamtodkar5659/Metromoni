<?php
include 'vars.php';
include 'include/load.php';
connect_db();
require_once 'include/class-Emailer.php';

if (isset($_POST["flag"]) && $_POST["flag"] == 1 && isset($_POST["email_val"])) {
    $pass = getRandomString(5); //uniqid(rand(), 1);
    $pass_encode = md5($pass);
    $flag = 0;
    $email_val = $_POST["email_val"];
    $db_update = $db->query_update("UPDATE user_regiter SET password = '$pass_encode' WHERE  email='$email_val' ");
    $sql2 = $db_update['success'];
    $result  = (!empty($db_update["success"])) ? $db_update["success"] : 0;
    if (!empty($result)) {
        $flag = 1;
        $mail_obj = new Emailer();
        $body_text = "Hi User, <br> Your password has been reset successfully.<br> New password is $pass <br> from Devyog Vivah Team";
        $data_var = $mail_obj->send_email('Password Reset', $body_text, $email_val, 'renukakul93@gmail.com', '');
    }
    echo $flag;
}

function getRandomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}

if (isset($_POST["flag"]) && $_POST["flag"] == 2 && isset($_POST["password"]) && isset($_POST["current_user"])) {
    $current_user =  $_POST["current_user"];
    $pass_encode = md5($_POST["password"]);
    $flag = 0;
    $db_update = $db->query_update("UPDATE user_regiter SET password = '$pass_encode' WHERE  id='$current_user' ");
    $sql2 = $db_update['success'];
    $result  = (!empty($db_update["success"])) ? $db_update["success"] : 0;
    if (!empty($result)) {
        $flag = 1;
    }
    echo $flag;
}
