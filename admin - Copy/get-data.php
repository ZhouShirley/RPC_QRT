<?php

# Database Connection
include('../config/connection.php');

		//if(!empty($_POST["select_emp"]))	{
			error_log (" get data php the passed emp is : ".$_POST["select_emp"]);
			$q1 = "SELECT * FROM pages WHERE emp_id='".$_POST["select_emp"]."'";
			$r1 = mysqli_query($dbc, $q1);
			error_log ("the query in get data php is : ".$q1);
			
			//echo "<ul>";
			foreach ($r1 as $sub_rec){
				if ($sub_rec['is_locked']=="readonly"){
					
				
					echo "<li style='list-style: none;'>";
					echo "<a href = 'index.php?id=". $sub_rec['id']."'>"."<h4 class='list-group-item-heading'><span class='glyphicon glyphicon-lock'></span>". $sub_rec['title']."</h4>"."</a>";
					echo "</li>";
					
				}else{
					
					echo "<li style='list-style: none;'>";
					echo "<a  href = 'index.php?id=". $sub_rec['id']."'>"."<h4 class='list-group-item-heading'>". $sub_rec['title']."</h4>"."</a>";
					echo "</li>";
					
				}
				
			}
			//echo "</ul>";
			
		
			
		//exit;
		//}	
			
		
?>
							