<?php
	require_once('load.php');
	$j->password_change('login.php');
?>

<html>
	<head>
		<title>Password Change Form</title>
		<style type="text/css">
			body { background: #c7c7c7;}
		</style>
	</head>

	<body>
		<div style="width: 960px; background: #fff; border: 1px solid #e4e4e4; padding: 20px; margin: 10px auto;">
			<h3>Password Change</h3>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table>
					
					<tr>
						<td>Please Enter New Password:</td>
						<td><input type="password" name="password" /></td>
					</tr>
						<input type="hidden" name="date" value="<?php echo time(); ?>" />
					<tr>
						<td></td>
						<td><input type="submit" value="Change Password" /></td>
					</tr>
				</table>
			</form>
			<p>Do not want to change password? <a href="login.php">Log in here</a></p>
		</div>
	</body>
</html>