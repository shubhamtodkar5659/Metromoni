<?php
 
require_once 'vars.php';

if ( file_exists( ABSPATH . INC. '/load.php' ) ) {  
	require_once ABSPATH . INC .  '/load.php';
}
 
connect_db();
connect_home();
