<?php

//setup file:
# Database Connection
include('config/connection.php');

//constants:
DEFINE('D_TEMPLATE','template');

# functions:
include('functions/data.php');
include('functions/template.php');

# site setup:
$debug = data_setting_value($dbc, 'debug-status');
$site_title = 'MyTest1.0';
//$page_title = 'Home Page';

if(isset($_GET['page'])){
	
	$pageid = $_GET['page'];//set $pageid equal to the value given in URL
}else{
	
	$pageid = 1;// Set $pageid equal to 1 or the Home page
}


//page setup
  $page=data_page($dbc, $pageid); 
  

  
?>