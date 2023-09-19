<?php
require_once 'vars.php';
require_once  'include/load.php';
require_once 'include/class-Emailer.php';
connect_db();
$user_id = $_POST['user_id'];
$current_user_name = $_POST['current_user_name'];
$current_user_email = $_POST['current_user_email'];
$user_details = $db->query("SELECT * FROM `user_regiter` WHERE `id` =  $user_id");
$user_data = !empty($user_details['rows']) ? $user_details['rows'][0] : array();
$user_name = $user_data['name'];
$user_email = $user_data['email'];

$current_user_body = "You have seen $user_name's profile ";
$mail_obj = new Emailer();
$mail_obj->send_email('You have visited profile', $current_user_body, $current_user_email, '', '');


$user_body = "Your profile was visited by $current_user_name "; 
$mail_obj->send_email('Your profile was visited', $user_body, $user_email, '', '');
