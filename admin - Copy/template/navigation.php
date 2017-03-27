<nav class="navbar navbar-custom" role = "navigation" >
		
		
	
	<!--<ul class="nav navbar-nav">
			<?php error_log ("the full name of the user in navigation php file is ".$user['fullname']);//nav_main($dbc,$pageid);?>
			
	</ul>-->	
	
	<div class = "pull-left" name="nav-bar">
		<ul class="nav navbar-nav" >
						
			 <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Welcome! <?php echo $user['fullname'];?> <b class="caret"></b></a>
			          <ul class="dropdown-menu">
			          	<li><a href="login.php?action=logout">Logout</a></li>
						<li><a href="password_change.php">Change Password</a></li>
			          </ul>
        	</li>
			
			
			
		</ul>
	</div>		
</nav>
			