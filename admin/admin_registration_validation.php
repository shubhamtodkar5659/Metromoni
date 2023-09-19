<?php
// include 'vars.php';
include 'load.php';
connect_db();
global $db;
if (isset($_POST["email_val"])) {
    $flag = 0;
    $email_val = $_POST["email_val"];
    $result = $db->query("SELECT * FROM `admin` WHERE `email` = '$email_val' ");
    $result_rows = (!empty($result["success"])) ? $result["rows"] : '';
    // print_r($result_rows);
    if (!empty($result_rows)) {
        $flag = 1;
    }
    echo $flag;
}
if (isset($_POST["phone_val"])) {
    $flag = 0;
    $phone_val = $_POST["phone_val"];
    $result = $db->query("SELECT * FROM `admin` WHERE `mobile` = '$phone_val' ");
    $result_rows = (!empty($result["success"])) ? $result["rows"] : '';
    // print_r($result_rows);
    if (!empty($result_rows)) {
        $flag = 1;
    }
    echo $flag;
}
