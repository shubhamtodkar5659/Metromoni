<?php

function connect_db() { 
	global $db;
	
	require_once '../include/config.php';
	require_once '../include/class-dbconnect.php';
	
	$dbuser     = defined( 'DB_USER' ) ? DB_USER : '';
	$dbpassword = defined( 'DB_PASSWORD' ) ? DB_PASSWORD : '';
	$dbname     = defined( 'DB_NAME' ) ? DB_NAME : '';
	$dbhost     = defined( 'DB_HOST' ) ? DB_HOST : '';
	
	$db = new DB( $dbhost, $dbuser, $dbpassword, $dbname );
}
function connect_admin_home() { 
	require_once 'admin_home.php';
}