<?php

//setup file:

error_reporting(0); //not sending warnings or errors

# Database Connection
include('../config/connection.php');

//constants:
DEFINE('D_TEMPLATE','template');

# functions:
include('functions/data.php');
include('functions/template.php');

# site setup:
//$debug = data_setting_value($dbc, 'debug-status');
$site_title = 'NPC QRT';
//$page_title = 'Home Page';

//if(isset($_GET['page'])){
	
	//$pageid = $_GET['page'];//set $pageid equal to the value given in URL
//}else{
	
//	$pageid = 'home';// Set $pageid equal to 1 or the Home page
//}


//page setup
  $page=data_page($dbc, $pageid); 
  $user = data_employee($dbc, $_SESSION['username']);

?>