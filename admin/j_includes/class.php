<?php
require_once('load.php');
$link = mysqli_connect('eco72648',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
// Our main class
if(!class_exists('Joomba')){
	class Joomba {
		
		function register($redirect) {
			global $jdb;
		
			//Check to make sure the form submission is coming from our script
			//The full URL of our registration page
			$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			//The full URL of the page the form was submitted from
			$referrer = $_SERVER['HTTP_REFERER'];

			/*
			 * Check to see if the $_POST array has date (i.e. our form was submitted) and if so,
			 * process the form data.
			 */
			if ( !empty ( $_POST ) ) {

				/* 
				 * Here we actually run the check to see if the form was submitted from our
				 * site. Since our registration from submits to itself, this is pretty easy. If
				 * the form submission didn't come from the register.php page on our server,
				 * we don't allow the data through.
				 */
				if ( $referrer == $current ) {
				
					//Require our database class
					require_once('db.php');
						
					//Set up the variables we'll need to pass to our insert method
					//This is the name of the table we want to insert data into
					$table = 'login_test';
					
					//These are the fields in that table that we want to insert data into
					$fields = array('char_id', 'user_pass', 'user_email', 'user_registered');
					
					//These are the values from our registration form... cleaned using our clean method
					$values = $jdb->clean($_POST);
					
					//Now, we're breaking apart our $_POST array, so we can storely our password securely
					$char_id  = $_POST['char_id'];
					//$username = $_POST['name'];
					//$userlogin = $_POST['username'];
					$userpass = $_POST['password'];
					$useremail = $_POST['email'];
					$userreg = $_POST['date'];
					
					//We create a NONCE using the action, username, timestamp, and the NONCE SALT
					//$nonce = md5('registration-' . $char_id . $userreg . NONCE_SALT);
					
					//We hash our password
					$userpass = md5($userpass);
					
					//Recompile our $value array to insert into the database
					$values = array(
								'char_id' => $char_id,
								//'name' => $username,
								//'username' => $userlogin,
								'password' => $userpass,
								'email' => $useremail,
								'date' => $userreg
							);
					
					//And, we insert our data
					$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
					$insert = $jdb->insert($link, $table, $fields, $values);
					
					if ( $insert == TRUE ) {
						$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$aredirect = str_replace('register.php', $redirect, $url);
						
						header("Location: $aredirect?reg=true");
						exit;
					}
				} else {
					die('Your form submission did not come from the correct page. Please check with the site administrator.');
				}
			}
		}
		
		function password_change($redirect) {
			global $jdb;
		
			//Check to make sure the form submission is coming from our script
			//The full URL of our registration page
			$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			//The full URL of the page the form was submitted from
			$referrer = $_SERVER['HTTP_REFERER'];

			/*
			 * Check to see if the $_POST array has date (i.e. our form was submitted) and if so,
			 * process the form data.
			 */
			if ( !empty ( $_POST ) ) {

				/* 
				 * Here we actually run the check to see if the form was submitted from our
				 * site. Since our password change from submits to itself, this is pretty easy. If
				 * the form submission didn't come from the register.php page on our server,
				 * we don't allow the data through.
				 */
				if ( $referrer == $current ) {
								
					//Require our database class
					require_once('db.php');
					
					//Grab our authorization cookie array
					$cookie = $_COOKIE['joombologauth'];
				
					//Set our user and authID variables
					$user = $cookie['user'];
								
					//Set up the variables we'll need to pass to our insert method
					//This is the name of the table we want to insert data into
					$table = 'login_test';
					
					//These are the fields in that table that we want to insert data into
					$fields = array('char_id', 'user_pass', 'user_email', 'user_registered');
					
					//These are the values from our registration form... cleaned using our clean method
					//$values = $jdb->clean($_POST);
					
					//Now, we're breaking apart our $_POST array, so we can storely our password securely
					$char_id  = $user;
					//$username = $_POST['name'];
					//$userlogin = $_POST['username'];
					$userpass = $_POST['password'];
					//$useremail = $_POST['email'];
					$user_pass_change = $_POST['date'];
					
					//We create a NONCE using the action, username, timestamp, and the NONCE SALT
					//$nonce = md5('registration-' . $char_id . $user_pass_change . NONCE_SALT);
					
					//We hash our password
					$userpass = md5($userpass);
					
					//Recompile our $value array to update into the database
					$values = array(
								'char_id' => $char_id,
								//'name' => $username,
								//'username' => $userlogin,
								'password' => $userpass,
								//'email' => $useremail,
								'date' => $user_pass_change
							);
					
					//And, we update our data
					//$link = mysql_connect('localhost', DB_USER, DB_PASS);
					$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
					$q = "UPDATE login_test SET user_pass= '$userpass' WHERE char_id = '$char_id'";
					$update_pass = mysqli_query($link, $q);
					//$insert = $jdb->insert($link, $table, $fields, $values);

					
					if ( $update_pass == TRUE ) {
						error_log("pass change success, sql query is " .$q);
						$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$aredirect = str_replace('password_change.php', $redirect, $url);
						
						header("Location: $aredirect?pass_change=true");
						exit;
					}else{
						error_log("update inquery is  ".$q);
						mysql_error($link);
					}
				} else {
					
					die('Your form submission did not come from the correct page. Please check with the site administrator.');
				}
			}
		}
		
		function login($redirect) {
			global $jdb;
			$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error()); 
		
			if ( !empty ( $_POST ) ) {
				
				//Clean our form data
				//$values = $jdb->clean($_POST); //clean function not working ,probably mysqli extenstion not installed. 
				
				//The username and password submitted by the user
				$char_id = mysqli_real_escape_string($link,$_POST['username']);
				$subpass = mysqli_real_escape_string($link,$_POST['password']);
				
				//$char_id = $values['username'];
				//$subpass = $values['password'];
				error_log("returned value of clean user name is ". $char_id);
				error_log("returned value of clean password is ". $subpass);
				
				//The name of the table we want to select data from
				$table = 'login_test';

				/*
				 * Run our query to get all data from the users table where the user 
				 * login matches the submitted login.
				 */
				//$link = mysqli_connect('eco71147',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
				$sql = "SELECT * FROM $table WHERE char_id = '" . $char_id . "'";
				$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
				$results = $jdb->select($link,$sql);
				
				
				if($results){
					//echo ("user name password success in login");
					$_SESSION['username'] = $_POST['username'];
					error_log("the value of sesssion user name is" . $_SESSION['username']);
				}
				//Kill the script if the submitted username doesn't exit
				if (!$results) {
					echo ("failure in login function");
					die('Sorry, that username does not exist!');
					error_log ($sql);
				}
				
				
				//Fetch our results into an associative array
				$results = mysqli_fetch_assoc( $results );
				
				//The registration date of the stored matching user
				$storeg = $results['user_registered'];

				//The hashed password of the stored matching user
				$stopass = $results['user_pass'];

				//Recreate our NONCE used at registration
				//$nonce = md5('registration-' . $char_id . $storeg . NONCE_SALT);

				//Rehash the submitted password to see if it matches the stored hash
				$subpass = md5($subpass);

				//Check to see if the submitted password matches the stored password
				if ( $subpass == $stopass ) {
					
					//If there's a match, we rehash password to store in a cookie
					$authnonce = md5('cookie-' . $char_id . $storeg . AUTH_SALT);
					$authID = $jdb->hash_password($subpass, $authnonce);
					
					//Set our authorization cookie
					setcookie('joombologauth[user]', $char_id, 0, '', '', '', true);
					setcookie('joombologauth[authID]', $authID, 0, '', '', '', true);
					
					//Build our redirect
					$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
					$redirect = str_replace('login.php', $redirect, $url);
					
					//Redirect to the home page
					header("Location: $redirect");
					exit;	
				} else {
					return 'invalid';
				}
			} else {
				return 'empty';
			}
		}
		
		function logout() {
			//Expire our auth coookie to log the user out
			$idout = setcookie('joombologauth[authID]', '', -3600, '', '', '', true);
			$userout = setcookie('joombologauth[user]', '', -3600, '', '', '', true);
			
			if ( $idout == true && $userout == true ) {
				return true;
			} else {
				return false;
			}
		}
		
		function checkLogin() {
			global $jdb;
			
			//Grab our authorization cookie array
			$cookie = $_COOKIE['joombologauth'];
			
			//Set our user and authID variables
			$user = $cookie['user'];
			$authID = $cookie['authID'];
			
			
			error_log("cookie user name is ".$user);
			error_log("cookie password name is ".$authID);
			/*
			 * If the cookie values are empty, we redirect to login right away;
			 * otherwise, we run the login check.
			 */
			if ( !empty ( $cookie ) ) {
				
				//Query the database for the selected user
				$table = 'login_test';
				$sql = "SELECT * FROM $table WHERE user_login = '" . $user . "'";
				$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
				$results = mysqli_query($link,$sql);

				//Kill the script if the submitted username doesn't exit
				if (!$results) {
					echo ("failure in checklogin function");
					die('Sorry, that username does not exist!');
				}

				//Fetch our results into an associative array
				$results = mysqli_fetch_assoc( $results );
		
				//The registration date of the stored matching user
				$storeg = $results['user_registered'];

				//The hashed password of the stored matching user
				$stopass = $results['user_pass'];

				//Rehash password to see if it matches the value stored in the cookie
				//$authnonce = md5('cookie-' . $user . $storeg . AUTH_SALT);
				$stopass = md5($stopass);
				
				if ( $stopass == $authID ) {
					$results = true;
				} else {
					$results = false;
				}
			} else {
				//Build our redirect
				$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$redirect = str_replace('index.php', 'login.php', $url);
				
				//Redirect to the home page
				//header("Location: $redirect?msg=login");
				header("Location: login.php");
				exit;
			}
			
			return $results;
		}
	}
}

//Instantiate our database class
$j = new Joomba;
?>