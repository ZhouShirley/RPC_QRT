 <?php 
global $is_leader_id;
global $is_locked;
$is_locked= "";
//include('../../wp-blog-header.php');
# start session:
session_start();
//$current_user = wp_get_current_user();
//error_log("the values of current user id is ". $current_user->ID);

require_once('load.php');
//$dbc = mysqli_connect('eco72648','shirley','','npc_lounge_wordpress') or die('Could not connect because:'.mysqli_connect_error());

$logged = $j->checkLogin();
//echo ($_SERVER['PHP_AUTH_USER']);
//error_log("the value of logged is ". $logged);

/* if ($logged == false){
	//build the redirect
	//session_destroy();
	$url = "http".((!empty($_SEVER['HTTPS'])) ? "s" : "") . "://".$_SEVER['SERVER_NAME'].$_SESSION['REQUEST_URI'];
	$redirect = str_replace('index.php', 'login.php', $url);
	
	//redirect to the home page
	header ("Location: $redirct?msg=login");
	exit();
	}else{*/
	if ($logged == true){
		//Grab the authorization cookie array
		$cookie = $_COOKIE['joombologauth'];
		
		//Set our user and authID variables
		$user = $cookie['user'];
		$authID = $cookie['authID'];
		
		//Query the database for the selected user
		$table = 'login_test';
		$sql = "SELECT * FROM $table WHERE char_id = '$user'";
		$results = $jdb->select($link,$sql);
		
		//Kill the script if the submitted username doesn't exit
		if (!$results) {
			error_log ($sql);
			die('Sorry, that username does not exist!');
		}

		//Fetch our results into an associative array
		$results = mysqli_fetch_assoc( $results );
	
	} 
	
?>

<?php include('config/setup.php');?>
 
<!DOCTYPE html>
<html>
  <!-- Bootstrap -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker3.min.css" rel="stylesheet">
 
<head>
	<title>NPC Coaching</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="generator" content="jqueryform.com">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<?php include('config/css.php');?>
	
	<?php include('config/js.php');?>
	
</head>
	
<body>
<header>
<div class="container">
   <a href="index.php"><img src="images/sample1.jpg" alt="logo" /></a>
</div>
</header>
<?php include(D_TEMPLATE.'/navigation.php'); //Page Navigation ?>

<h1><strong>NPC Coaching Database</strong></h1>
	
<div class="row">
	
		
		
	<div class= "col-md-9">
			
			<?php
				if (isset($_GET['id'])){
					$selected_id = $_GET['id'];
					$q = "SELECT * FROM pages WHERE id = $_GET[id]";
					$r = mysqli_query($dbc, $q);
					
					$opened = mysqli_fetch_assoc($r);
					$is_locked = $opened['is_locked'];
					//error_log("well" .  $opened['well_challenge']);
				}
			?>
			<form action="index.php" method="POST" role="form">
				<div id="form-content">
				<div class="section">
					<h2 class ="form-group" for="title">Title</h2>
					<input  class="form-control" type="text" name="title" value="<?php echo mc_decrypt($opened['title'],ENCRYPTION_KEY);?>" placeholder="" readonly>
				
				
				<?php 
					$q= "SELECT * FROM employee WHERE leader_id = '$_SESSION[username]'";
					//$link = mysqli_connect('eco71147',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
					error_log($q);
					$r = mysqli_query($dbc,$q);
					
					//error_log ("the returned no of rows from database of this user name is ".mysqli_num_rows($r));
					if(mysqli_num_rows($r)>0){?>	
					<?php	
						$is_leader_id = true;
						error_log ("is a leader id? ". $is_leader_id);
						error_log ($_SESSION[username]." is a leader id");
					?>
				
				<div class="section">
					<h2  class ="form-group" for="leader">Leader</h2>
					<input  class="form-control" type="text" name="leader" value= "<?php echo strtoupper($_SESSION[username]);?>" placeholder="" readonly>
				 </div>
							
				<div class="section">
					<h2 class ="form-group"  for="employee">Employee</h2>
				</div>	
					<select class="form-control" name="employee" id="employee" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
				    	<option value ="0"> Please Select</option>
				    
				    	<?php
				    	$q = "SELECT * FROM employee WHERE leader_id = '$_SESSION[username]' ORDER BY first ASC";
						$r = mysqli_query($dbc,$q);
					
						while ($emoloyee_list = mysqli_fetch_assoc($r)){ 
							$employee_data=data_employee($dbc, $emoloyee_list['emp_id']);
							?>
							<option value ="<?php echo $employee_data['emp_id']?>"
							<?php if (isset($opened['emp_id'])){
									
									if($employee_data['emp_id']==$opened['emp_id']){echo 'selected';}
								} 	
								?>><?php echo $employee_data['fullname'];?> </option>
						<?php } ?>  	
				    	
				    </select>
				 			
				
				    
				   
				
					<?php }else{?> 
					<?php  
						$is_leader_id = false;
						error_log ("is a leader id? ". $is_leader_id);
						error_log ($_SESSION[username]. " is not a leader id");
						
						$q = "SELECT * FROM employee WHERE emp_id = '$_SESSION[username]'";
						$r = mysqli_query($dbc,$q);
						$result = mysqli_fetch_assoc($r);
						error_log ($q);
						//error_log ("the returned no of rows from database of this user name is ".mysql_num_rows($r));
						if(mysqli_num_rows($r)>0){?>
							<div class="section">
								<h2  class ="form-group"  for="leader">Leader</h2>
								<input  class="form-control" type="text" name="leader" value= "<?php echo $result['leader_id'];?>" placeholder="" readonly>
							</div>
				
							<div class="section">
								<h2 class ="form-group" for="employee">Employee</h2>
								<input  class="form-control" type="text" name="employee" value= "<?php echo $result['emp_id'];?>" placeholder="" readonly>
							</div>
							
						<?php }else{ 
							error_log($q);
							error_log ("no such user in database");?>
							<div class="form-group">
								<label for="employee">Employee</label>
								<input  class="form-control" type="text" name="employee" placeholder="this user account has not been created in database, please contact admin" >
							</div>	
						<?php }?>
									
					
				
					<?php }?>
					
				
				<!-- Include Bootstrap Datepicker -->
				<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
				<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
				<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
				
				  <!--<script type="text/javascript" src="/bower_components/jquery/jquery.min.js"></script> -->
				  <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
				  <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
				  <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
				  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
				  <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
								
				 <div id="eventForm" class="section">
			        <h2 for="date">Coaching Time</h2>
			            <div class="input-group date" id="datePicker" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
			                <input  data-format="YYYY-MM-DD hh:mm"  class="form-control" type="text" id="date" name="date" <?php echo $is_locked ;?> />
			                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			            </div>
				</div>
			      
   				</div>
				
   				 <script>
					$(document).ready(function() {
					    $('#datePicker').datetimepicker({
								//format:'YYYY-MM-DD hh:mm'
								defaultDate: "<?php echo $opened['date'];?>"
							});
									
				});
					/* <?php if (isset($_GET['id'])){?>
					//var date = new Date(Date.parse($opened['date'],"YYYY-MM-DD hh:mm"));
					$("#datePicker").data("DateTimePicker").val("<?php echo $opened['date'];?>");
					<?php }else{?>
						
					$("#datePicker").datetimepicker("setDate", new Date());	
						<?php }?> */
					//console.log datePicker.value.Date;
				</script>
				
				 
				 <br>
				<br>
				<div class="section">
				<h2 class="title" >Goal 1: Engagement</h2>	
					<div class="form-group">
					  <label class="control-label" >Commentary</label>
						<div class="form-group c137 " data-cid="c137">
						<textarea type="text"  class="form-control" rows="4" id="com_engage" name="com_engage" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['com_engage'],ENCRYPTION_KEY);?></textarea>
						</div>
						
						<?php
						if ($opened['rating_engage']==1){$r1="selected";$bc="#F1560A";}else{$r1="";};
						if ($opened['rating_engage']==2){$r2="selected";$bc="#CC99FF";}else{$r2="";};
						if ($opened['rating_engage']==3){$r3="selected";$bc="#D3EA0E";}else{$r3="";};
						if ($opened['rating_engage']==4){$r4="selected";$bc="#6AF411";}else{$r4="";};
						if ($opened['rating_engage']==5){$r5="selected";$bc="#31C8F7";}else{$r5="";};
						
						?>
						
						<label class="control-label">Rating</label>
						<select name="rating_engage" id="rating_engage" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "0" <?php echo $r1?>> Please Select</option>
						<option class="red" value= "1" <?php echo $r1?>>1 - Greater than 10% below target</option>
						<option class="mauve" value= "2" <?php echo $r2?>>2 - Developing/Processing as expected for time in role</option>
						<option class="yellow" value= "3" <?php echo $r3?>>3 - Within 10% of target</option>
						<option class="green" value= "4" <?php echo $r4?>>4 - On or above target</option>
						<option class="blue" value= "5" <?php echo $r5?>>5 - Significantly Exceeds</option>
						</select>
						
						<script>
						var elementId = "rating_engage"
						var classNumber = document.getElementById("rating_engage");
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value==1)
								document.getElementById("rating_engage").style.backgroundColor="#F1560A";
								if(value==2)
									document.getElementById("rating_engage").style.backgroundColor="#CC99FF";
								if(value==3)
									document.getElementById("rating_engage").style.backgroundColor="#D3EA0E";
								if(value==4)
									document.getElementById("rating_engage").style.backgroundColor="#6AF411";
								if(value==5)
									document.getElementById("rating_engage").style.backgroundColor="#31C8F7";
								
							
							} else {
								document.getElementById("rating_engage").style.backgroundColor="";
							};
						}
						</script>
						
						
					</div>
				</div>	
				<br>
				<!-- Goal 2 Customer service -->
				<div class="section" data-cid="c34">
				 <h1 class="title" for="c34">Goal 2: Customer Service</h1>
				  <h2 class="title" for="c34">Monthly Call Stats</h2>

						<div class="form-group c49 " data-cid="c49">
						<label class="control-label" for="c49">Calls Handled</label>
						<div class="form-group c56 " data-cid="c56">
						<label class="control-label" for="c56">Individual Result (Employee Completed)</label>
						
						<input type="text" class="form-control" id="calls_handle_ind" name="calls_handle_ind" value="<?php echo mc_decrypt($opened['calls_handle_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>  />
						
					
						</div>

						<div class="form-group c63 " data-cid="c63">
						<label class="control-label" for="c63">Team Average/Target (Leader Completed)</label>
						<input type="text" class="form-control" id="calls_handle_team" name="calls_handle_team" value="<?php echo mc_decrypt($opened['calls_handle_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>    />
						</div>

						</div>
				

				<div class="form-group c73 " data-cid="c73">
				<label class="control-label" for="c73">Active Talk Time</label>
				<div class="form-group c78 " data-cid="c78">
					<label class="control-label" for="c78">Individual Result (Employee Compeleted)</label>
					<input type="text" class="form-control" id="talk_time_ind" name="talk_time_ind" value="<?php echo mc_decrypt($opened['talk_time_ind'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>

					<div class="form-group c83 " data-cid="c83">
					<label class="control-label" for="c83">Team Average/Target (Leader Completed)</label>
					<input type="text" class="form-control" id="talk_time_team" name="talk_time_team" value= "<?php echo mc_decrypt($opened['talk_time_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>    />
					</div>
				</div>


				<div class="form-group c97 " data-cid="c97">
				<label class="control-label" for="c97">Average Handle Time</label>
					<div class="form-group c102 " data-cid="c102">
					<label class="control-label" for="c102">Individual Result (Employee Completed)</label>
					<input type="text" class="form-control" id="handle_time_ind" name="handle_time_ind" value="<?php echo mc_decrypt($opened['handle_time_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>   />
					</div>


					<div class="form-group c107 " data-cid="c107">
					<label class="control-label" for="c107">Team Average/Target (Leader Completed)</label>
					<input type="text" class="form-control" id="handle_time_team" name="handle_time_team" value="<?php echo mc_decrypt($opened['handle_time_team'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>   />
					</div>
				  
				</div>

				<div class="form-group c112 " data-cid="c112">
				<label class="control-label" for="c112">Not Ready Time</label>
					<div class="form-group c117 " data-cid="c117">
					<label class="control-label" for="c117">Individual Result (Employee Completed)</label>
					<input type="text" class="form-control" id="not_ready_ind" name="not_ready_ind" value="<?php echo mc_decrypt($opened['not_ready_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>   />
					</div>


					<div class="form-group c122 " data-cid="c122">
					  <label class="control-label" for="c122">Team Average/Target (Leader Completed)</label>
					<input type="text" class="form-control" id="not_ready_team" name="not_ready_team" value="<?php echo mc_decrypt($opened['not_ready_team'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>   />
					</div>
				</div>

		
				<div class="form-group c132 " data-cid="c132">
				  <label class="control-label" for="c132">Commentary</label>
					<div class="form-group c137 " data-cid="c137">
					
					<textarea type="text"  class="form-control" rows="4" id="com_call" name="com_call" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['com_call'],ENCRYPTION_KEY);?></textarea>
					</div>
					
					<?php
						if ($opened['rating_cs']==1){$r1="selected";$bc="#F1560A";}else{$r1="";};
						if ($opened['rating_cs']==2){$r2="selected";$bc="#CC99FF";}else{$r2="";};
						if ($opened['rating_cs']==3){$r3="selected";$bc="#D3EA0E";}else{$r3="";};
						if ($opened['rating_cs']==4){$r4="selected";$bc="#6AF411";}else{$r4="";};
						if ($opened['rating_cs']==5){$r5="selected";$bc="#31C8F7";}else{$r5="";};
						
						?>
						<br>
						<label class="control-label">Rating</label>
						<select name="rating_cs" id="rating_cs" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "0" <?php echo $r1?>> Please Select</option>
						<option class="red" value= "1" <?php echo $r1?>>1 - Greater than 10% below target</option>
						<option class="mauve" value= "2" <?php echo $r2?>>2 - Developing/Processing as expected for time in role</option>
						<option class="yellow" value= "3" <?php echo $r3?>>3 - Within 10% of target</option>
						<option class="green" value= "4" <?php echo $r4?>>4 - On or above target</option>
						<option class="blue" value= "5" <?php echo $r5?>>5 - Significantly Exceeds</option>
						</select>
						
						<script>
						var elementId = "rating_cs"
						var classNumber = document.getElementById("rating_cs");
						classNumber.onchange = runBackgroundChange;
						function runBackgroundChange(first){
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value==1)
									document.getElementById("rating_cs").style.backgroundColor="#F1560A";
								if(value==2)
									document.getElementById("rating_cs").style.backgroundColor="#CC99FF";
								if(value==3)
									document.getElementById("rating_cs").style.backgroundColor="#D3EA0E";
								if(value==4)
									document.getElementById("rating_cs").style.backgroundColor="#6AF411";
								if(value==5)
									document.getElementById("rating_cs").style.backgroundColor="#31C8F7";
								
							
							} else {
								document.getElementById("rating_cs").style.backgroundColor="";
							};
						}
						</script>
				</div>
				
				
			</div>
				
			<br>
			<br>
			<!-- Goal 3 : quality review  -->
			<div class="section " data-cid="c34">
				  <h2 class="title" for="c34">Goal 3 : Quality</h2>
				  <h2 class="title" for="c34">Quality Reviews</h2>

						<div class="form-group c49 " data-cid="c49">
						<label class="control-label" for="c49">Transactional Review</label>
						<div class="form-group c56 " data-cid="c56">
						<label class="control-label" for="c56">Individual Result (Employee Completed)</label>
						<input type="text" class="form-control" id="trans_rev_ind" name="trans_rev_ind" value="<?php echo mc_decrypt($opened['trans_rev_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>    />
						</div>

						<div class="form-group c63 " data-cid="c63">
						<label class="control-label" for="c63">Team Average/Target (Leader Completed)</label>
						<input type="text" class="form-control" id="trans_rev_team" name="trans_rev_team" value="<?php echo mc_decrypt($opened['trans_rev_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
						</div>

						</div>

						<div class="form-group c73 " data-cid="c73">
						<label class="control-label" for="c73">Other quality reviews (i.e. re-categorization, renewal put on manual review, broker feedback, etc.)</label>
						<div class="form-group c78 " data-cid="c78">
							<label class="control-label" for="c78">Individual Result (Employee Compeleted)</label>
							<input type="text" class="form-control" id="other_qua_ind" name="other_qua_ind" value="<?php echo mc_decrypt($opened['other_qua_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>     />
						</div>

							<div class="form-group c83 " data-cid="c83">
							<label class="control-label" for="c83">Team Average/Target (leader completed)</label>
							<input type="text" class="form-control" id="other_qua_team" name="other_qua_team" value="<?php echo mc_decrypt($opened['other_qua_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
							</div>
						</div>


						<div class="form-group c97 " data-cid="c97">
						<label class="control-label" for="c97">Call Reviews</label>
							<div class="form-group c102 " data-cid="c102">
							<label class="control-label" for="c102">Individual Result (Employee Completed)</label>
							<input type="text" class="form-control" id="call_rev_ind" name="call_rev_ind" value="<?php echo mc_decrypt($opened['call_rev_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>    />
							</div>

							<div class="form-group c107 " data-cid="c107">
							<label class="control-label" for="c107">Team Average/Target (Leader Completed)</label>
							<input type="text" class="form-control" id="call_rev_team" name="call_rev_team" value="<?php echo mc_decrypt($opened['call_rev_team'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>    />
							</div>
						</div>
						
												
						<div class="form-group" >
						  <label class="control-label" for="c132">Commentary</label>
							<textarea type="text" rows="4" class="form-control" id="qua_com" name="qua_com"  <?php echo $is_locked ;?> > <?php echo mc_decrypt($opened['qua_com'],ENCRYPTION_KEY);?></textarea>
						
						<?php
						if ($opened['rating_quality']==1){$r1="selected";$bc="#F1560A";}else{$r1="";};
						if ($opened['rating_quality']==2){$r2="selected";$bc="#CC99FF";}else{$r2="";};
						if ($opened['rating_quality']==3){$r3="selected";$bc="#D3EA0E";}else{$r3="";};
						if ($opened['rating_quality']==4){$r4="selected";$bc="#6AF411";}else{$r4="";};
						if ($opened['rating_quality']==5){$r5="selected";$bc="#31C8F7";}else{$r5="";};
						
						?>
						<br>
						<label class="control-label">Rating</label>
						<select name="rating_quality" id="rating_quality" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "0" <?php echo $r1?>> Please Select</option>
						<option class="red" value= "1" <?php echo $r1?>>1 - Greater than 10% below target</option>
						<option class="mauve" value= "2" <?php echo $r2?>>2 - Developing/Processing as expected for time in role</option>
						<option class="yellow" value= "3" <?php echo $r3?>>3 - Within 10% of target</option>
						<option class="green" value= "4" <?php echo $r4?>>4 - On or above target</option>
						<option class="blue" value= "5" <?php echo $r5?>>5 - Significantly Exceeds</option>
						</select>
						
						<script>
						var elemendId = "rating_quality"
						var classNumber = document.getElementById("rating_quality");
						classNumber.onchange = runBackgroundChange;
						function runBackgroundChange(first){
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value==1)
								document.getElementById("rating_quality").style.backgroundColor="#F1560A";
								if(value==2)
									document.getElementById("rating_quality").style.backgroundColor="#CC99FF";
								if(value==3)
									document.getElementById("rating_quality").style.backgroundColor="#D3EA0E";
								if(value==4)
									document.getElementById("rating_quality").style.backgroundColor="#6AF411";
								if(value==5)
									document.getElementById("rating_quality").style.backgroundColor="#31C8F7";
								
							
							} else {
								document.getElementById("rating_quality").style.backgroundColor="";
							};
						}
						</script>
						
						
						
						</div>

				 
			</div>
			<br>
			<br>	
		
			<!-- Goal 4 : processing stats  -->
			<div class="section " data-cid="c34">
				  <h2 class="title" for="c34">Goal 4 : Production</h2>
				  <h2 class="title" for="c34">Processing Stats</h2>

				<div class="form-group c49 " data-cid="c49">
						<label class="control-label" for="c49">Cases Closed</label>
						<div class="form-group c56 " data-cid="c56">
						<label class="control-label" for="c56">Individual Result (Employee Completed)</label>
						<input type="text" class="form-control" id="case_close_ind" name="case_close_ind" value="<?php echo mc_decrypt($opened['case_close_ind'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
						</div>

						<div class="form-group c63 " data-cid="c63">
						<label class="control-label" for="c63">Team Average/Target (Leader Completed)</label>
						<input type="text" class="form-control" id="case_close_team" name="case_close_team" value="<?php echo mc_decrypt($opened['case_close_team'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>    />
						</div>

				</div>

				<div class="form-group c73 " data-cid="c73">
				<label class="control-label" for="c73">Cases Touched</label>
				<div class="form-group c78 " data-cid="c78">
					<label class="control-label" for="c78">Individual Result (Employee Compeleted)</label>
					<input type="text" class="form-control" id="case_touch_ind" name="case_touch_ind" value="<?php echo mc_decrypt($opened['case_touch_ind'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>

					<div class="form-group c83 " data-cid="c83">
					<label class="control-label" for="c83">Team Average/Target (Leader Completed)</label>
					<input type="text" class="form-control" id="case_touch_team" name="case_touch_team" value="<?php echo mc_decrypt($opened['case_touch_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>
				</div>


				<div class="form-group c97 " data-cid="c97">
				<label class="control-label" for="c97">Touch Time(median)</label>
					<div class="form-group c102 " data-cid="c102">
					<label class="control-label" for="c102">Individual Result (Employee Completed)</label>
					<input type="text" class="form-control" id="tt_ind" name="tt_ind" value="<?php echo mc_decrypt($opened['tt_ind'],ENCRYPTION_KEY);?>"  <?php echo $is_locked ;?>    />
					</div>

					<div class="form-group c107 " data-cid="c107">
					<label class="control-label" for="c107">Team Average/Target (Leader Completed)</label>
					<input type="text" class="form-control" id="tt_team" name="tt_team" value="<?php echo mc_decrypt($opened['tt_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>
				</div>

				<div class="form-group c112 " data-cid="c112">
				<label class="control-label" for="c112">Productive Hours(monthly roll up - Leader completed)</label>
					<div class="form-group c117 " data-cid="c117">
					<label class="control-label" for="c117">Individual Result (Leader completed)</label>
					<input type="text" class="form-control" id="prod_hour_ind" name="prod_hour_ind" value="<?php echo mc_decrypt($opened['prod_hour_ind'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>


					<div class="form-group c122 " data-cid="c122">
					  <label class="control-label" for="c122">Team Average/Target (leader completed)</label>
					<input type="text" class="form-control" id="prod_hour_team" name="prod_hour_team" value="<?php echo mc_decrypt($opened['prod_hour_team'],ENCRYPTION_KEY);?>" <?php echo $is_locked ;?>     />
					</div>
				</div>


				<div class="form-group c132 " data-cid="c132">
				  <label class="control-label" for="c132">Commentary</label>
					<div class="form-group c137 " data-cid="c137">
					<textarea type="text"  class="form-control" rows="4" id="process_com" name="process_com" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['process_com'],ENCRYPTION_KEY);?></textarea>
					</div>
				
				</div>

				 
			</div>
				<!-- schedule review  -->
			<div class="section " data-cid="c34">
				  <h2 class="title" for="c34">Schedule Adherance</h2>
						
						<div class="form-group c49 " data-cid="c49">
							<label class="control-label" for="c49">Log on /Log off times</label>
							<label class="control-label" for="c56">Feedback(Employee & Leader Completed)</label>
							<textarea type="text"  class="form-control" rows="4" id="log_on_off" name="log_on_off" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['log_on_off'],ENCRYPTION_KEY);?> </textarea>
						</div>

						
						<div class="form-group c49 " data-cid="c49">
							<label class="control-label" for="c49">Break / Lunch Durations</label>
							<label class="control-label" for="c56">Feedback(Employee & Leader Completed)</label>
							<textarea type="text"  class="form-control" rows="4" id="break" name="break" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['break'],ENCRYPTION_KEY);?></textarea>
						</div>
						
						<div class="form-group c49 " data-cid="c49">
							<label class="control-label" for="c49">Attendance</label>
							<label class="control-label" for="c56">Feedback(Employee & Leader Completed)</label>
							<textarea type="text"  class="form-control" rows="4" id="attendance" name="attendance" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['attendance'],ENCRYPTION_KEY);?></textarea>
						</div>
					
						<div class="form-group c49 " data-cid="c49">
							<label class="control-label" for="c49">Commentary</label>
							<label class="control-label" for="c56">Feedback(Employee & Leader Completed)</label>
							<textarea type="text"  class="form-control" rows="4" id="sche_com" name="sche_com" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['sche_com'],ENCRYPTION_KEY);?></textarea>
						
						<?php
						if ($opened['rating_pr']==1){$r1="selected";$bc="#F1560A";}else{$r1="";};
						if ($opened['rating_pr']==2){$r2="selected";$bc="#CC99FF";}else{$r2="";};
						if ($opened['rating_pr']==3){$r3="selected";$bc="#D3EA0E";}else{$r3="";};
						if ($opened['rating_pr']==4){$r4="selected";$bc="#6AF411";}else{$r4="";};
						if ($opened['rating_pr']==5){$r5="selected";$bc="#31C8F7";}else{$r5="";};
						
						?>
						<br>
						<label class="control-label">Rating</label>
						<select name="rating_pr" id="rating_pr" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "0" <?php echo $r1?>> Please Select</option>
						<option class="red" value= "1" <?php echo $r1?>>1 - Greater than 10% below target</option>
						<option class="mauve" value= "2" <?php echo $r2?>>2 - Developing/Processing as expected for time in role</option>
						<option class="yellow" value= "3" <?php echo $r3?>>3 - Within 10% of target</option>
						<option class="green" value= "4" <?php echo $r4?>>4 - On or above target</option>
						<option class="blue" value= "5" <?php echo $r5?>>5 - Significantly Exceeds</option>
						</select>
						
						<script>
						var elementId = "rating_pr"
						var classNumber = document.getElementById("rating_pr");
						classNumber.onchange = runBackgroundChange;
						function runBackgroundChange(first){
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value==1)
								document.getElementById("rating_pr").style.backgroundColor="#F1560A";
								if(value==2)
									document.getElementById("rating_pr").style.backgroundColor="#CC99FF";
								if(value==3)
									document.getElementById("rating_pr").style.backgroundColor="#D3EA0E";
								if(value==4)
									document.getElementById("rating_pr").style.backgroundColor="#6AF411";
								if(value==5)
									document.getElementById("rating_pr").style.backgroundColor="#31C8F7";
								
							
							} else {
								document.getElementById("rating_pr").style.backgroundColor="";
							};
						}
						</script>
						</div>
							 
			</div>
				
			 <br>
            <!--Goal 5  -->
			<br>
			<br>
				<div class="section">
				<h2 class="title" >Goal 5: Growth</h2>	
					<div class="form-group">
					  <label class="control-label" >Commentary</label>
						<div class="form-group c137 " data-cid="c137">
						<textarea type="text"  class="form-control" rows="4" id="com_growth" name="com_growth" <?php echo $is_locked ;?>><?php echo mc_decrypt($opened['com_growth'],ENCRYPTION_KEY);?></textarea>
						</div>
						
						<?php
						if ($opened['rating_growth']==1){$r1="selected";$bc="#F1560A";}else{$r1="";};
						if ($opened['rating_growth']==2){$r2="selected";$bc="#CC99FF";}else{$r2="";};
						if ($opened['rating_growth']==3){$r3="selected";$bc="#D3EA0E";}else{$r3="";};
						if ($opened['rating_growth']==4){$r4="selected";$bc="#6AF411";}else{$r4="";};
						if ($opened['rating_growth']==5){$r5="selected";$bc="#31C8F7";}else{$r5="";};
						
						?>
						
						<label class="control-label">Rating</label>
						<select name="rating_growth" id="rating_growth" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "0" <?php echo $r1?>>Please Select</option>
						<option class="red" value= "1" <?php echo $r1?>>1 - Greater than 10% below target</option>
						<option class="mauve" value= "2" <?php echo $r2?>>2 - Developing/Processing as expected for time in role</option>
						<option class="yellow" value= "3" <?php echo $r3?>>3 - Within 10% of target</option>
						<option class="green" value= "4" <?php echo $r4?>>4 - On or above target</option>
						<option class="blue" value= "5" <?php echo $r5?>>5 - Significantly Exceeds</option>
						</select>
						
						<script>
						var elementId = "rating_growth"
						var classNumber = document.getElementById("rating_growth");
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value==1)
								document.getElementById("rating_growth").style.backgroundColor="#F1560A";
								if(value==2)
									document.getElementById("rating_growth").style.backgroundColor="#CC99FF";
								if(value==3)
									document.getElementById("rating_growth").style.backgroundColor="#D3EA0E";
								if(value==4)
									document.getElementById("rating_growth").style.backgroundColor="#6AF411";
								if(value==5)
									document.getElementById("rating_growth").style.backgroundColor="#31C8F7";
								
							
							} else {
								document.getElementById("rating_growth").style.backgroundColor="";
							};
						}
						</script>
						
						
					</div>
				</div>		
			
			
			<input type="hidden" name="page_id" id="page_id" value="<?php echo $_GET['id'] ?>" >
			<br>
			<div class="section">
			<div class="form-group" >
			
					<label class="title" for="well_challenge">What are you feeling really good about?(Employee&Leader Completed)</label>
				    <textarea class="form-control" rows="8" type="text" name="well" <?php echo $is_locked ;?>  ><?php echo mc_decrypt($opened['well'],ENCRYPTION_KEY);?></textarea>
			</div>	
			</div>
			
			<br>
			<div class="section">
			<div class="form-group">
					<label class="title" for="case_info">What are you not feeling really good about?(Employee&Leader Completed)</label>
				    <textarea class="form-control" rows="8" type="text" name="not_well" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['not_well'],ENCRYPTION_KEY);?></textarea>
			</div>
			</div>
							
					
			<br>	
			<div class="section">
			<div class="form-group">
				    <label class="title" for="next_employee">Next Step for Employee</label>
				    <textarea class="form-control"  rows="8" name="next_employee" placeholder="" <?php echo $is_locked ;?> ><?php echo mc_decrypt($opened['next_employee'],ENCRYPTION_KEY);?></textarea>
			</div>
			</div>
			
			<br>			
			<div class="section ">
			<div class="form-group">
				    <label class="title" for="next_leader">Next Step for Leader</label>
				    <textarea class="form-control"  rows="8" name="next_leader" placeholder=""<?php echo $is_locked ;?>  ><?php echo mc_decrypt($opened['next_leader'],ENCRYPTION_KEY);?></textarea>
			</div>
			</div>
			</div>
			
			<input type="checkbox" name="agree" id="agree" value=0  <?php if ($opened['agree']==1){echo ("checked");}?> <?php if ($is_locked=="readonly"){echo "disabled='disabled'  readonly";}?>/>  I agree with the contents of this coaching sheet (Employee Acknowledgement)
			<input type="text" id="agree_text" name = "agree_text" hidden/>
			<script>
			
			$(document).ready(function() {
			//set initial state.
			$('#agree_text').val($(this).is(':checked'));
			
			$('#agree').change(function() {
				if($(this).is(":checked")) {
					//var returnVal = confirm("Are you sure?");
					$(this).attr("checked", "true");
				}
				$('#agree_text').val($(this).is(':checked'));
			});
			});
			</script>
			
			
			<br>
			<br>
			
						
			<button type="submit" name="submitted" class="btn btn-default">Save</button>
			
			<?php
			function curPageURL() {
				
				
				 $pageURL = 'http';
				 // ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
				 $pageURL .= "://";
				 if ($_SERVER["SERVER_PORT"] != "80") {
				  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
				 } else {
				  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
				 }
				 //return $pageURL;
				  $parts = parse_url($pageURL);
				  parse_str($parts['query'], $query);
			     return $query['id'];

				}
			 
			?>
			<?php
			if ($is_leader_id){?>
				<button type="submit" name="locked" class="btn btn-default">Lock</button>
				<button type="submit" name="unlock" class="btn btn-default">Unlock</button>
				<a href="send_email.php?pageid=<?php echo curPageURL();?>" class="btn btn-default">Send Email</a>
				<a href="functions\PHPWord\samples\save_doc.php?html" class="btn btn-default">Download Document (developing)</a>				
			<?php $doc= new DomDocument;
			$doc->validateOnParse = true;
			echo "the form contennt is: ".$doc->getElementById('form-content');


			?>
			<?php }?>
			
				 <!-- <input type="hidden" name="submitted" value="1"> -->
		</form>
	</div>
			
		
		<div class= "col-md-3" id="sidebar">
			<div class ="list-group">
				
			<a class ="list-group-item" href = "index.php" style="background-color:#E6E6FA">
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>Add New Coaching</h4>
	       </a>				
			
			<?php
				if(isset($_POST['locked'])==1 ){
					error_log ("locked button  is submitted");
					if (isset($_POST['agree'])){
						error_log ("agree checkbox is checked");
						$is_locked="readonly";
						
						$q = "UPDATE pages SET is_locked='$is_locked',agree=1
							  WHERE id= $_POST[page_id]";
						
						error_log($q);
						$r = mysqli_query($dbc, $q);
						if($r){
							
								$message = '<p>Coaching sheet was locked successfully</p>';
								echo "<script type='text/javascript'>alert('Coaching sheet was locked successfully')</script>";	
									//echo $message;	
							}else{
			
								$message= '<p> Coaching sheet could not be locked because: '.mysqli_error($dbc).'</p>';
								//echo '<p>'.$q.'</p>';	
								echo $message;	
								echo "<script type='text/javascript'>alert('Coaching sheet could not be locked.')</script>";						
						}
						
					}
					
					 else{
						 echo ("agree checkbox is not checked");
						echo "<script type='text/javascript'>alert('Please indicate that you have read and agree to contents in this coaching sheet')</script>";
						
						
					} 
					
					
				}
				
				
				if(isset($_POST['unlock'])==1){
					$is_locked="";
					
					$q = "UPDATE pages SET is_locked='$is_locked'
						  WHERE id= $_POST[page_id]";
						  
					error_log($q);
					$r = mysqli_query($dbc, $q);
					if($r){
						
							$message = '<p>Coaching sheet was unlocked successfully</p>';
								echo "<script type='text/javascript'>alert('Coaching sheet was unlocked successfully')</script>";	
						}
						//header("Loaction:: index.php");
						
					
					else{
		
					$message= '<p> Coaching sheet could not be unlocked because: '.mysqli_error($dbc).'</p>';
					//echo '<p>'.$q.'</p>';	
					echo $message;			
					echo "<script type='text/javascript'>alert('Coaching sheet could not be unlocked successfully')</script>";
					}
				}
				
			
				if(isset($_POST['submitted'])==1){
				
				if ($_POST['agree_text']=="true"){
						$agree=mysqli_real_escape_string($dbc, "1");
				}else{
					$agree=mysqli_real_escape_string($dbc, "0");
				}
			
				$leader= mysqli_real_escape_string($dbc, $_POST['leader']);
				$employee= mysqli_real_escape_string($dbc, $_POST['employee']);
				$date= mysqli_real_escape_string($dbc, $_POST['date']);
				
				$title = mc_encrypt("Coaching ".$employee." by ".$leader. " on ". $_POST['date'],ENCRYPTION_KEY);
				//$title= mysqli_real_escape_string($dbc, $_POST['title']);
				
				$com_engage = mc_encrypt(mysqli_real_escape_string($dbc, $_POST['com_engage']),ENCRYPTION_KEY);
				$rating_engage = mysqli_real_escape_string($dbc, $_POST['rating_engage']);
				
				$calls_handle_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['calls_handle_ind']),ENCRYPTION_KEY);
				$calls_handle_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['calls_handle_team']),ENCRYPTION_KEY);
				$talk_time_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['talk_time_ind']),ENCRYPTION_KEY);
				$talk_time_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['talk_time_team']),ENCRYPTION_KEY);
				$handle_time_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['handle_time_ind']),ENCRYPTION_KEY);
				$handle_time_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['handle_time_team']),ENCRYPTION_KEY);
				$not_ready_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['not_ready_ind']),ENCRYPTION_KEY);
				$not_ready_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['not_ready_team']),ENCRYPTION_KEY);
				
				$com_call= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['com_call']),ENCRYPTION_KEY);
				$rating_cs = mysqli_real_escape_string($dbc, $_POST['rating_cs']);
				
				$case_close_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['case_close_ind']),ENCRYPTION_KEY);
				$case_close_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['case_close_team']),ENCRYPTION_KEY);
				
				$case_touch_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['case_touch_ind']),ENCRYPTION_KEY);
				$case_touch_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['case_touch_team']),ENCRYPTION_KEY);
				
				$tt_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['tt_ind']),ENCRYPTION_KEY);
				$tt_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['tt_team']),ENCRYPTION_KEY);
				
				$prod_hour_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['prod_hour_ind']),ENCRYPTION_KEY);
				$prod_hour_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['prod_hour_team']),ENCRYPTION_KEY);
				
				$process_com= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['process_com']),ENCRYPTION_KEY);
				
				
				$log_on_off= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['log_on_off']),ENCRYPTION_KEY);
				
				
				$break= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['break']),ENCRYPTION_KEY);
				
				
				$attendance= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['attendance']),ENCRYPTION_KEY);
			
				
				$sche_com= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['sche_com']),ENCRYPTION_KEY);
				$rating_pr = mysqli_real_escape_string($dbc, $_POST['rating_pr']);
				
				$trans_rev_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['trans_rev_ind']),ENCRYPTION_KEY);
				$trans_rev_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['trans_rev_team']),ENCRYPTION_KEY);
				
				$other_qua_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['other_qua_ind']),ENCRYPTION_KEY);
				$other_qua_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['other_qua_team']),ENCRYPTION_KEY);
				
				$call_rev_ind= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['call_rev_ind']),ENCRYPTION_KEY);
				$call_rev_team= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['call_rev_team']),ENCRYPTION_KEY);
				
				$qua_com= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['qua_com']),ENCRYPTION_KEY);
				$rating_quality = mysqli_real_escape_string($dbc, $_POST['rating_quality']);
				
				$com_growth= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['com_growth']),ENCRYPTION_KEY);
				$rating_growth = mysqli_real_escape_string($dbc, $_POST['rating_growth']);
				
				
				$well= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['well']),ENCRYPTION_KEY);
				$not_well= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['not_well']),ENCRYPTION_KEY);
				$next_employee= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['next_employee']),ENCRYPTION_KEY);
				$next_leader= mc_encrypt(mysqli_real_escape_string($dbc, $_POST['next_leader']),ENCRYPTION_KEY);
				
				if (isset($_POST['page_id']) && is_numeric($_POST['page_id'])){
					$q = "UPDATE pages SET leader_id='$leader', emp_id='$employee', 
					agree = '$agree',
					is_locked='$is_locked',
					date='$date', 
					title='$title',
					com_engage='$com_engage',
					rating_engage='$rating_engage',
					calls_handle_ind='$calls_handle_ind', 
					calls_handle_team='$calls_handle_team',
					talk_time_ind = '$talk_time_ind',
					talk_time_team = '$talk_time_team',
					handle_time_ind = '$handle_time_ind',
					handle_time_team = '$handle_time_team',
					not_ready_ind = '$not_ready_ind',
					not_ready_team = '$not_ready_team',
					com_call = '$com_call',
					case_close_ind = '$case_close_ind',
					case_close_team = '$case_close_team',
					case_touch_ind = '$case_touch_ind',
					case_touch_team = '$case_touch_team',
					tt_ind = '$tt_ind',
					tt_team = '$tt_team',
					prod_hour_ind = '$prod_hour_ind',
					prod_hour_team = '$prod_hour_team',
					process_com = '$process_com',
					log_on_off= '$log_on_off',
					break = '$break',
					attendance = '$attendance',
					sche_com= '$sche_com',
					trans_rev_ind = '$trans_rev_ind',
					trans_rev_team = '$trans_rev_team',
					other_qua_ind = '$other_qua_ind',
					other_qua_team = '$other_qua_team',
					call_rev_ind = '$call_rev_ind',
					call_rev_team = '$call_rev_team',
					qua_com= '$qua_com',
					rating_cs='$rating_cs',
					rating_pr='$rating_pr',
					rating_quality='$rating_quality',
					rating_growth='$rating_growth',
					com_growth='$com_growth',
					well='$well', 
					not_well='$not_well', 
					next_employee='$next_employee',
					next_leader='$next_leader' WHERE id= $_POST[page_id]";
				}else {
						$q = "INSERT pages (emp_id, 
						leader_id, 
						date, 
						agree,
						is_locked,
						title, 
						com_engage,
						rating_engage,
						calls_handle_ind, 
						calls_handle_team,
						talk_time_ind,
						talk_time_team,
						handle_time_ind,
						handle_time_team,
						not_ready_ind,
						not_ready_team,
						com_call,
						case_close_ind,
						case_close_team,
						case_touch_ind,
						case_touch_team,
						tt_ind,
						tt_team,
						prod_hour_ind,
						prod_hour_team,
						process_com,
						log_on_off,
						break,
						attendance,
						sche_com,
						trans_rev_ind,
						trans_rev_team,
						other_qua_ind,
						other_qua_team,
						call_rev_ind,
						call_rev_team,
						qua_com,
						rating_cs,
						rating_pr,
						rating_quality,
						rating_growth,
						com_growth,
						well, 
						not_well,
						next_employee,
						next_leader) 
				VALUES ('$employee', 
						'$leader',
						'$date',
						'$agree',
						'$is_locked',
						'$title',
						'$com_engage',
						'$rating_engage',
						'$calls_handle_ind',
						'$calls_handle_team',
						'$talk_time_ind',
						'$talk_time_team',
						'$handle_time_ind',
						'$handle_time_team',
						'$not_ready_ind',
						'$not_ready_team',
						'$com_call',
						'$case_close_ind',
						'$case_close_team',
						'$case_touch_ind',
						'$case_touch_team',
						'$tt_ind',
						'$tt_team',
						'$prod_hour_ind',
						'$prod_hour_team',
						'$process_com',
						'$log_on_off',
						'$break',
						'$attendance',
						'$sche_com',
						'$trans_rev_ind',
						'$trans_rev_team',
						'$other_qua_ind',
						'$other_qua_team',
						'$call_rev_ind',
						'$call_rev_team',
						'$qua_com',
						'$rating_cs',
						'$rating_pr',
						'$rating_quality',
						'$rating_growth',
						'$com_growth',
						'$well', 
						'$not_well', 
						'$next_employee',
						'$next_leader')"; 
				}
				
				
				
				error_log($q);
				$r = mysqli_query($dbc, $q);
				if($r){
					if (isset($_POST['page_id']) && is_numeric($_POST['page_id'])){
						$message = '<p>Coaching sheet was updated successfully</p>';
					    echo "<script type='text/javascript'>alert('Coaching sheet was updated successfully!')</script>";	
					}else {
						$message = '<p>Coaching sheet was added successfully</p>';	
						echo "<script type='text/javascript'>alert('Coaching sheet was added successfully!')</script>";						
					}
					//header("Loaction:: index.php");
					echo $message;
				}
				else{
	
				$message= '<p> Coaching sheet could not be added because: '.mysqli_error($dbc).'</p>';
				echo "<script type='text/javascript'>alert('Coaching sheet could not be added successfully!')</script>";			
				//echo '<p>'.$q.'</p>';	
				echo $message;			
				}
				
			}
		    ?>
			
			<?php 
			if ($is_leader_id){
			$q = "SELECT * FROM pages WHERE leader_id = '$_SESSION[username]' GROUP BY emp_id ORDER BY date";
			$r = mysqli_query($dbc, $q);
			error_log ($q);
			}else{
			$q = "SELECT * FROM pages WHERE emp_id = '$_SESSION[username]' GROUP BY emp_id ORDER BY date";
			$r = mysqli_query($dbc, $q);
			error_log ($q);
			
			}
			$current_rec = null;
		/* 	while ($page_list = mysqli_fetch_assoc($r)){ 
			error_log ("success in inqury!");
			if ($page_list["emp_id"]!=$current_rec){
					
					$current_rec = $page_list["emp_id"];
					echo "<ul class='nav nav-pills nav-stacked'>";
					//echo "<h4>Employee: ". $current_rec."</h4>";
					echo "<li class='dropdown'>".
					"<a class='dropdown-toggle' data-toggle='dropdown' href='#'>"."<h4 class='list-group-item-heading'> ".$current_rec."</h4>"."<span class='caret'></span></a>".
					"</li>"
					;
					
				}
				
				if ($page_list['is_locked']=="readonly"){
					echo "<ul class='dropdown-menu'>".
					" <li class='dropdown'>".
					"<a class ='list-group-item' href = 'index.php?id=". $page_list['id']."'>"."<h4 class='list-group-item-heading'><span class='glyphicon glyphicon-lock'></span>". $page_list['title']."</h4>"."</a>".
					"</ul>".
					"</li>";
				}else{
					echo "<ul class='dropdown-menu'>".
					" <li class='dropdown'>".
					"<a class ='list-group-item' href = 'index.php?id=". $page_list['id']."'>"."<h4 class='list-group-item-heading'>". $page_list['title']."</h4>"."</a>".
					"</ul>".
					"</li>";
				}
			
				 }?> */
				 echo "<div id='accordion'  >";
				 foreach ($r as $current_rec){ 
				 
				 $employee_data=data_employee($dbc, $current_rec['emp_id']);
				 
				//echo "<li class='dropdown' style='list-style: none;'>";
				
				
				echo "<h4>".$employee_data['fullname']."</h4>";
			
					$q1 = "SELECT * FROM pages WHERE emp_id='". $current_rec['emp_id']."'";
					$r1 = mysqli_query($dbc, $q1);
					//echo "<ul id = 'demo' class = 'dropdown-menu'>";
					echo "<ul>";
					foreach ($r1 as $sub_rec){
						
						if ($sub_rec['is_locked']=="readonly"){
						
							echo "<li><a href = 'index.php?id=". $sub_rec['id']."'>"."<span class='glyphicon glyphicon-lock'></span>". mc_decrypt($sub_rec['title'],ENCRYPTION_KEY)."</a></li>";
							
						}else{

							echo "<li><a href = 'index.php?id=". $sub_rec['id']."'>". mc_decrypt($sub_rec['title'],ENCRYPTION_KEY)."</a></li>";
							
						}
						
					}
					echo "</ul>";
					//echo "</ul>";
				
				
				}
		echo "</div>";
				;?>
				
				
				<script>
				  $( function() {
					$( "#accordion" ).accordion({
					  collapsible: true,
					  autoHeight: false,
					  active: false,
					  navigation: true
					});
				  } );
				  
				
		
				</script>
				 
				<script type="text/javascript">
				$(document).ready( function() {
					
					// initialize accordion
					$('#accordion ul').each( function() {
						var currentURI = window.location.href;
						var links = $('a', this);
						var collapse = true;
						for (var i = 0; i < links.size(); i++) {
							var elem = links.eq(i);
							var href = elem.attr('href');
							var hrefLength = href.length;
							var compareTo = currentURI.substr(-1*hrefLength);
							
							if (href == compareTo) {
								collapse = false;
								break;
							}
						};
						if (collapse) {
							$(this).hide();
						}
					});
					
					// on click, show this element and hide all others
					$('#accordion > li').click( function() {
						var me = $(this).children('ul');
						$('#accordion ul').not(me).slideUp();
						me.slideDown();
					});
				});
				</script>
				  
				
	
				<script src="http://d3js.org/d3.v3.min.js"></script>
				<script src="https://rawgit.com/gka/d3-jetpack/master/d3-jetpack.js"></script>
		
			</div>
	</div>
	
	</div>	
	<?php //include(D_TEMPLATE.'/footer.php'); //Page Footer ?>
          	    
</body>
</html>