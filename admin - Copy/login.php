<?php 
session_start();
require_once('load.php');
	if ( isset($_GET['action']) == 'logout' ) {
		$loggedout = $j->logout();
	}
	
	$logged = $j->login('index.php');
# Database Connection
//include('../config/connection.php');


/* if($_POST){
	$q = "SELECT * FROM login_test WHERE char_id = '$_POST[username]' AND user_pass = MD5('$_POST[password]')";
	$r = mysqli_query($link, $q);
	
	
	if(mysqli_num_rows($r)== 1){
		echo ("user name password success in login");
		$_SESSION['username'] = $_POST['username'];
		error_log("the value of sesssion user name is" . $_SESSION['username']);
		header('Location:index.php');
	}else{
		error_log ("user name password combination wrong");
	}
	
} */
 
 ?>
 
<!DOCTYPE html>
<html>
<head>
<h1> </h1>
	<title>Admin Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include('config/css.php'); ?>
	
	<?php include('config/js.php');?>
</head>
	
<body>

	<?php //include(D_TEMPLATE.'/navigation.php'); //Page Navigation ?>
	
	<div class="container">
	<?php if ( $logged == 'invalid' ) : ?>
				<p style="background: #e49a9a; border: 1px solid #c05555; padding: 7px 10px;">
					The username password combination you entered is incorrect. Please try again.
				</p>
			<?php endif; ?>
			<?php if ( isset($_GET['reg']) == 'true' ) : ?>
				<p style="background: #fef1b5; border: 1px solid #eedc82; padding: 7px 10px;">
					Your registration was successful, please login below.
				</p>
			<?php endif; ?>
			<?php if ( isset($_GET['pass_change']) == 'true' ) : ?>
				<p style="background: #fef1b5; border: 1px solid #eedc82; padding: 7px 10px;">
					Your password change was successful, please login below.
				</p>
			<?php endif; ?>
			<?php if ( isset($_GET['action']) == 'logout' ) : ?>
				<?php if ( $loggedout == true ) : ?>
					<p style="background: #fef1b5; border: 1px solid #eedc82; padding: 7px 10px;">
						You have been successfully logged out.
					</p>
				<?php else: ?>
					<p style="background: #e49a9a; border: 1px solid #c05555; padding: 7px 10px;">
						There was a problem logging you out.
					</p>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( isset($_GET['msg']) == 'login' ): ?>
				<p style="background: #e49a9a; border: 1px solid #c05555; padding: 7px 10px;">
						You must log in to view this content. Please log in below.
					</p>
			<?php endif; ?>
	
	<div class="row">
		
		
		<div class="col-md-4 col-md-offset-4">
			
			<div class="panel panel-info">
							
				<div class="panel-heading">
					
					<strong>Please Login</strong>
				</div> <!--end panel heading-->
								
				<div class="panel-body">
			
			<form action ="login.php" method = "post" role="form"> <!--defines where to send the data when the form is submitted -->
			
			  <div class="form-group">
			    <label for="username">User Name</label>
			    <input type="username" class="form-control" id="username" name="username" placeholder="3 character id">
			  </div>
		  
			  <div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" id="password" name="password" placeholder="Initial Pass is Capitalized 3 char ID">
			  </div>
		  
			<button type="submit" class="btn btn-default">Submit</button>
			<!--<p>Not a member? <a href="register.php">Register here</a></p>-->
			<p>Default password is the Capitalized 3 character ID </p>
			<p>Please contact shirely.zhou@economical.com if you have any questions.</p>
			
			</form>
		
		</div>
		
		</div>
    </div>
 </div>
		
		
	
	</div>
		
	<?php //include(D_TEMPLATE.'/footer.php'); //Page Footer ?>
   
    <?php //if($debug == 1){ include('widgets/debug.php');}?>
    	
</body>
</html>