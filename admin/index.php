 <?php 
global $is_leader_id;
global $is_locked;
$is_locked= "";
global $green;
$green = "#C0F867";
global $red; 
$red = "#F57D59";
global $white; 
$white = "#FFFFFF";


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
 
global $review_template_type;
if(isset($_GET['review_template'])||isset($_POST['review_template'])){
	if(isset($_GET['review_template'])){
		$review_template_type = $_GET['review_template'];
	error_log ("review template type got from url review template is: ".$review_template_type);
	}
	if(isset($_POST['review_template'])){
		$review_template_type = $_POST['review_template'];
		error_log ("review template type got from search panel is: ".$review_template_type);
	} 
	
	
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
	<title>NPC QRT Form</title>
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

<h1><strong>NPC QRT Form</strong></h1>
	
<div class="row">
	
		
		
	<div class= "col-md-9">
			
			<?php
				if (isset($_GET['trt_id'])){
					$selected_id = $_GET['trt_id'];
					$q = "SELECT * FROM transactionalreviewtable WHERE id = $_GET[trt_id]";
					$r = mysqli_query($dbc, $q);
					$opened = mysqli_fetch_assoc($r);
					//$is_locked = $opened['is_locked'];
					//error_log("well" .  $opened['well_challenge']);
				}else if (isset($_GET['irt_id'])){
					$selected_id = $_GET['irt_id'];
					$q = "SELECT * FROM intakereviewtable WHERE ID = $_GET[irt_id]";
					$r = mysqli_query($dbc, $q);
					$opened = mysqli_fetch_assoc($r);
				}else if (isset($_GET['crt_id'])){
					$selected_id = $_GET['crt_id'];
					$q = "SELECT * FROM callreviewtable WHERE id = $_GET[crt_id]";
					$r = mysqli_query($dbc, $q);
					$opened = mysqli_fetch_assoc($r);
				}
				
			?>
			<form id = "main_form" action="index.php" method="POST" role="form">
				
				<div class="section">
					<label class ="form-group" for="title">Page ID</label>
					<input  class="form-control" type="text" name="ID" id="ID"value="<?php echo $opened['ID'];?>" placeholder="" readonly> 
				
					<label class ="form-group" for="title">Review Template Type <span class="mandatory">***</span></label>
					<input  class="form-control" type="text" name="review_template" id="review_template" value=
					"<?php if($_GET['review_template']=='TRT'){echo 'TRT';} else if ($_GET['review_template']=='IRT'){
						echo 'IRT';
					}else if ($_GET['review_template']=='CRT'){
						echo 'CRT';
					}
				?>" placeholder="review template" readonly> 
				
				<div class="section">
				<label  class ="form-group" for="leader">Reviewee Name <span class="mandatory">***</span></label>
				<!--h2 class ="form-group" for="title">Leader Name</h2> -->
				<select class="form-control" name="Assigned_To" id="Assigned_To" >
				<option value = "Null"> Please Select Reviewee Name </option>
				<?php 
					$q= "SELECT * FROM userlistqrt WHERE TeamLeader = 0";
					//$link = mysqli_connect('eco71147',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
					error_log($q);
					$r = mysqli_query($dbc,$q);
					while ($employee_list = mysqli_fetch_assoc($r)){ 
					//error_log("The query result from user list table is: ".$employee_list['3CHID']);
				?>		
				<option value ="<?php echo $employee_list['3CHID']?>"
				<?php if (isset($opened['Assigned_To'])){
									
									if($employee_list['AgentName']==$opened['Assigned_To']){echo 'selected';}
								} 	
								?>>
				<?php echo $employee_list['AgentName']?> </option>
				<?php }?>				
				</select>
				
				<input  class="form-control" type="hidden" name="Assigned_To_hidden_name" id = "Assigned_To_hidden_name" value = "">
					<label  class ="form-group" for="leader">Reviewee ID</label>
					<input  class="form-control" type="text" name="AT_TCH" id = "AT_TCH" value= "<?php echo $opened['AT_TCH'];?>" readonly>
					<script>
					 $('#Assigned_To').change(function(){
						//alert($(this).val());
						$('#AT_TCH').val($(this).val());
					});  

				</script>
				
				</div>
				
				<div class="section">
				<label  class ="form-group" for="leader">Leader Name <span class="mandatory">***</span></label>
				<!--h2 class ="form-group" for="title">Leader Name</h2> -->
				<select class="form-control" name="Team_Leader" id="Team_Leader" >
				<option value = "Null"> Please select team leader name </option>
				<?php 
					$q= "SELECT * FROM userlistqrt WHERE TeamLeader = 1";
					//$link = mysqli_connect('eco71147',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
					error_log($q);
					$r = mysqli_query($dbc,$q);
					while ($employee_list = mysqli_fetch_assoc($r)){ 
					//error_log("The query result from user list table is: ".$employee_list['3CHID']);
				?>		
				<option value ="<?php echo $employee_list['3CHID']?>"
				<?php if (isset($opened['Team_Leader'])){
									
									if($employee_list['AgentName']==$opened['Team_Leader']){echo 'selected';}
								} 	
								?>>
				<?php echo $employee_list['AgentName']?> </option>
				<?php }?>				
				</select>
				
				<input class="form-control" type="hidden" name="Team_Leader_hidden_name" id = "Team_Leader_hidden_name" value = "">
					<label  class ="form-group" for="leader">Leader ID</label>
					<input  class="form-control" type="text" name="TL_TCH" id = "TL_TCH" value="<?php echo $opened['TL_TCH']?>"  placeholder="Leader ID" readonly>
					<script>
						 $('#Team_Leader').change(function(){
							//alert($(this).val());
							$('#TL_TCH').val($(this).val());
						});  

					</script>
				
				</div>
				<br>
				<div class="section">
					
				
					<label  class ="form-group" for="reviewer">Reviewer Name<span class="mandatory">***</span></label>
					<!--<h2  class ="form-group" for="leader">Reviewer Name</h2>-->
					<select class="form-control" name="Reviewed_By" id="Reviewed_By" >
					<option value = "Null"> Please select the Reviewer Name </option>
					<?php 
						$q= "SELECT * FROM userlistqrt WHERE Reviewer = 1";
						//$link = mysqli_connect('eco71147',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());
						error_log($q);
						$r = mysqli_query($dbc,$q);
						while ($employee_list = mysqli_fetch_assoc($r)){ 
						//error_log("The query result from user list table is: ".$employee_list['3CHID']);
					?>		
					<option value ="<?php echo $employee_list['3CHID']?>"
					<?php if (isset($opened['Reviewed_By'])){
										
										if($employee_list['AgentName']==$opened['Reviewed_By']){echo 'selected';}
									} 	
									?>>
					<?php echo $employee_list['AgentName']?> </option>
					<?php }?>				
					</select>
					
					<input class="form-control" type="hidden" name="Reviewed_By_hidden_name" id = "Reviewed_By_hidden_name" value = "">	
					<label  class ="form-group" for="leader">Reviewer ID</label>
					<!--<h2  class ="form-group" for="leader">Reviewer ID</h2>-->
					<input  class="form-control" type="text" name="RB_TCH" id="RB_TCH" value= "<?php echo $opened['RB_TCH']//strtoupper($_SESSION[username]);?>" placeholder="" readonly>
					
					<script>
						 $('#Reviewed_By').change(function(){
							//alert($(this).val());
							$('#RB_TCH').val($(this).val());
						});  

					</script>
					
				</div>
				<br>
				<div class="section">
				
					<!--<label  class ="form-group" for="leader">Review Template Type</label>
					
					<select class="form-control" name="review_type" id="review_type" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
					
						<option value= "0" > Please Select</option>
						<option value= "1" > Transaction Review</option>
						<option value= "2" > Intake Review</option>
						<option value= "3" > Call Review</option>
					</select>	-->
				<div>
				
					<label  class ="form-group" for="leader">Review Type<span class="mandatory">***</span></label>
					
					<select class="form-control"  name="Review_Type" id="Review_Type" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option value= "Monthly" <?php if($opened['Review_Type']=="Monthly"){echo "selected";} ?>> Monthly</option>
						<option value= "Optional" <?php if($opened['Review_Type']=="Optional"){echo "selected";} ?>> Optional</option>
					</select>	
					
				</div>
			<?php if ($review_template_type=="TRT"){?>
				<div>
					
					<label  class ="form-group" for="leader">Review Month</label>
					
					<select class="form-control"  name="Review_Month" id="Review_Month" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<?php
						$review_month = array ("January","February","March","April","May","June","July","August","September","October","November","December")
						?>
						
						<?php foreach ($review_month as $key => $value):	
						if ($opened['Review_Month']==$value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						
					</select>	
					
				</div>
			<?php }?>
				</div>
				
				
				
				</div>

				<br>
				
				<div class="section">
				<!--<h2 class="title" >Goal 1: Engagement</h2>	-->
					<div class="form-group">
						<label class="control-label" >Case Number<span class="mandatory">***</span></label>
						<input  class="form-control"  id="Case_Number" name="Case_Number" <?php echo $is_locked ;?> value="<?php echo $opened['Case_Number'];?>" >
						<?php if ($review_template_type=="TRT"){?>
						<label class="control-label">Policy Number </label>
						<input  class="form-control"  id="Policy_Number" name="Policy_Number" <?php echo $is_locked ;?> value= "<?php echo $opened['Policy_Number'];?>" >
						<?php }?>
						<label class="control-label">Transaction Type<span class="mandatory">*</span></label>
												
						<select class="form-control" name="Transaction_Type" id="Transaction_Type"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php $trans_type= array("Abeyance","CAC Inquiry","Cancellation","Cert of Ins - Needed","Cert of Ins - Submitted","Claims Alert","Inquiry","Large Loss","Letter of Authority","Letter of Experience","New Business","Policy Change","Quote","Re-Instatement","Renewal")?>
						
						
						<?php foreach ($trans_type as $key => $value):	
						if ($opened['Transaction_Type']==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						</select>
						
											
						
						<label class="control-label">Line of Business</label>
												
						<select class="form-control" name="Line_of_Business" id="Line_of_Business"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php if($review_template_type=='TRT'){ 
									$lob= array("Express","IRCA","PI Auto","PI Property");
								}else if ($review_template_type=='IRT'){
									$lob= array("National","Regional");
						} ?>
						
						<?php foreach ($lob as $key => $value):	
							if ($opened['Line_of_Business']==$value){
								echo '<option value="'.$value.'" selected>'.$value.'</option>';
							}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
							}
							endforeach;
						?>
						</select>
						
						<label class="control-label">Region</label>
												
						<select class="form-control" name="Region" id="Region" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" > Please Select</option>
						<?php $region= array("Alberta","Atlantic","British Columbia","Ontario","Prairies","Quebec");?>
						<?php foreach ($region as $key => $value):	
						if($opened['Region']==$value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						
						</select>
						
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
							<label for="date">Transaction Processed Date</label>
								<div class="input-group date" id="datePicker" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
									<input  data-format="YYYY-MM-DD hh:mm"  class="form-control" type="text" id="Effective_Date" name="Effective_Date" <?php echo $is_locked ;?> />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
						</div>
						  
						</div>
						
						 <script>
							$(document).ready(function() {
								$('#datePicker').datetimepicker({
										//format:'yyyy-mm-dd'
										defaultDate: "<?php echo $opened['Effective_Date'];?>"
										//console.log($('#datePicker').datepicker('getDate'));
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
						
						
				</div>
					
					
					
				<!-- Question section -->
				
				<!--<h2 class="title" >Goal 1: Engagement</h2>	-->
					
	<div class="form-group">
			<script>
						var green = "<?php echo $GLOBALS['green'];?>"
						var red = "<?php echo $GLOBALS['red'];?>"
						var white = "<?php echo $GLOBALS['white'];?>"
			</script>
			<?php if ($review_template_type=='TRT'){ ?>		
						
						<div class="section">
				
						<label class="control-label" >Risk Assessment: Was all the information received and considered accordingly in the assessment of the risk?</label>
						
						<br>
						<?php
						
						if ($opened['Risk_Assessment_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Risk_Assessment_Result']=='No') {$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Risk_Assessment_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
											
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Risk_Assessment_Result" id="Risk_Assessment_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var green = "<?php echo $GLOBALS['green'];?>"
						var red = "<?php echo $GLOBALS['red'];?>"
						var white = "<?php echo $GLOBALS['white'];?>"
						
						result_select_box_color_change("Risk_Assessment_Result")
						function result_select_box_color_change(elementId){
						var elementId = "Risk_Assessment_Result"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;
						}
						function runBackgroundChange(first){
							var elementId="Risk_Assessment_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							console.log ("the select option in risk assessment result box is: ", value);
							if (value != 0) {
								
								if(value=="Yes")
									document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Risk_Assessment_Score" id = "Risk_Assessment_Score" value="<?php echo $opened['Risk_Assessment_Score'];?>"  placeholder="Risk_Assessment_Score" readonly >
						<script>
							 $('#Risk_Assessment_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Risk_Assessment_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Risk_Assessment_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Risk_Assessment_Score').val('10');
								} else{
									$('#Risk_Assessment_Score').val('Null');
								}
							});  
						</script>
		
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Risk_Assessment_Observations" id="Risk_Assessment_Observations"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null > Please Select</option>
						<?php $risk_observation_type= array("A doc should be updated","Appraisals not received and/or assessed", "BI limits to receipts was not verified",
						"Broker segmentation was not assessed","Cargo and/or attached equipment is not known", "Claims/Prior Carrier loss history was not assessed",
						"Construction code is inaccurate","cross reference policies not addressed","CVOR - not reviewed","Discounts are incorrect","Driving record is incorrect",
						"Industry code is incorrect","Limit retention is incorrect","Operations not fully addressed",						
						"Other","Photos not received and/or assessed","Qualifying criteria not adequately addressed","Questionnaire not received and/or assessed","Reate groups are incorrect",
						"Reports are not ordered","Reports not reviewed","Risk is ineligible for Express","Risk profile not adequately addressed","Surcharges are incorrect",
						"Territory is incorrect","Vehicle use is not known","N/A") ?>
							
						<?php
						foreach ($risk_observation_type as $key => $value):
						if($opened['Risk_Assessment_Observations']==$value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Risk_Assessment_Comments" name="Risk_Assessment_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Risk_Assessment_Comments'];?></textarea>						
						
					</div>
					<br>
					
					<!--Focus #2: Data Accuracy-->
					<div class="section">
						
						<label class="control-label" >Data Accuracy: Were the key data fields entered correctly in order to properly rate the policy?</label>
						
						<br>
						<?php
						if ($opened['Data_Accuracy_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Data_Accuracy_Result']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Data_Accuracy_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Data_Accuracy_Result" id="Data_Accuracy_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Data_Accuracy_Result"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Data_Accuracy_Result"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="hidden" class="form-control" type="text" name="Data_Accuracy_Score" id = "Data_Accuracy_Score" value = "<?php echo $opened['Data_Accuracy_Score'];?>" readonly >
						<script>
							 $('#Data_Accuracy_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Data_Accuracy_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Data_Accuracy_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Data_Accuracy_Score').val('10');
								} else{
									$('#Data_Accuracy_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Data_Accuracy_Observations" id="Data_Accuracy_Observations"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $data_observation_type= array("Address entered incorreclty","Effective date incorrect","Named insured entered incorrectly","Other",
						"Rating incorrect due to incorrect data entry","Renewal flow through","Underwriting incorrect due to data entry","N/A") ?>
							
						<?php
						foreach ($data_observation_type as $key => $value):	
						if($opened['Data_Accuracy_Observations'] == $value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Data_Accuracy_Comments" name="Data_Accuracy_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Data_Accuracy_Comments'];?></textarea>						
						
					</div>
					
					<br>
					<!--Focus #3: Rating-->
					<div class="section">
						
						<label class="control-label" >Rating: Was the risk classified appropriately with no deviation? Where a deviation or an exception was applied, was it applied correclty with appropriate documentation?</label>
						
						<br>
						<?php
						if ($opened['Rating_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Rating_Result']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Rating_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Rating_Result" id="Rating_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Rating_Result";
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Rating_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Rating_Score" id = "Rating_Score" value="<?php echo $opened['Rating_Score']; ?>"  placeholder="Rating_Score" readonly >
						<script>
							 $('#Rating_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Rating_Score').val("20");
								} else if($(this).val()=="No"){//no
									$('#Rating_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Rating_Score').val('20');
								}else{
									$('#Rating_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Rating_Observations" id="Rating_Observations" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $rating_observation_type= array("Address and Postal Code has not been overridden","GVW does not reflect ownership","LPN not entered correctly","Other","Premium overridden/modified",
						"Premium override/modification not documented","Rating incorrect due to incorrect data entry","The address/postal code is incorrect","The highest hazard/liability exposure was not selected for rating","N/A") ?>
							
						<?php
						foreach ($rating_observation_type as $key => $value):						
						if($opened['Rating_Observations'] == $value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Rating_Comments" name="Rating_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Rating_Comments'];?></textarea>						
						
					</div>
			
				<br>
				
				
			 <!-- Underwriting -->
			 <div class="section">
						
						<label class="control-label" >Underwriting: Was the risk written in accordance with published underwriting guidelines?</label>
						
						
						<?php
						if ($opened['Underwriting_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Underwriting_Result']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Underwriting_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						<br>
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Underwriting_Result" id="Underwriting_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Underwriting_Result"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Underwriting_Result"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor="";
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Underwriting_Score" id = "Underwriting_Score" value="<?php echo $opened['Underwriting_Score']?>"  placeholder="Underwriting_Score" readonly >
						<script>
							 $('#Underwriting_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Underwriting_Score').val("20");
								} else if($(this).val()=="No"){//no
									$('#Underwriting_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Underwriting_Score').val('20');
								} else{
									$('#Underwriting_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Underwriting_Observations" id="Underwriting_Observations"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $underwriting_observation_type= array("Acceptability issues not managed appropriately", "Business not written in accordance with A/R/N guidelines", "Coverages applied are incorrect", 
						"Deductibles applied are incorrect", "Endorsements applied are incorrect","Limits applied are incorrect","LIT flag was not actioned appropriately","Misclassification",
						"MSB not received/addressed","Other","Subject to letter not sent out","Underwriting exceptions not documented","N/A") ?>
					
		
						<?php
						foreach ($underwriting_observation_type as $key => $value):
						if($opened['Underwriting_Observations']==$value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Underwriting_Comments" name="Underwriting_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Underwriting_Comments'];?></textarea>						
				
					</div>
					<br>
			<!--Information Gathering-->	
				<div class="section">
						
						<label class="control-label" >Information Gathering: Was any missing information requested and was the file abeyance appropriately set?</label>
						
						<br>
						<?php
						if ($opened['Information_Gathering_Result']=="Yes"){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Information_Gathering_Result']=="No"){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Information_Gathering_Result']=="N/A"){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Information_Gathering_Result" id="Information_Gathering_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Information_Gathering_Result";
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Information_Gathering_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor="";
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Information_Gathering_Score" id = "Information_Gathering_Score" value="<?php echo $opened['Information_Gathering_Score'];?> "readonly >
						<script>
							 $('#Information_Gathering_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Information_Gathering_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Information_Gathering_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Information_Gathering_Score').val('10');
								} else{
									$('#Information_Gathering_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Information_Gathering_Observations" id="Information_Gathering_Observations"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $information_observation_type= array("Abeyances not appropriate in duration","Abeyances not closed when information received","Missing information not pursued and/or abeyance not set",
						"Other","Signatures received on endorsements where required","N/A") ?>
					
		
						<?php
						foreach ($information_observation_type as $key => $value):						
						if($opened['Information_Gathering_Observations'] == $value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Information_Gathering_Comments" name="Information_Gathering_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Information_Gathering_Comments'];?></textarea>						
				
					</div>
					<br>
					
	<!--Underwriting Authority-->	
				<div class="section">
						
						<label class="control-label" >Underwriting Authority: Was the file written/ decision made in accordance with approved underwriting authority?</label>
						
						<br>
						<?php
						if ($opened['Underwriting_Authority_Result']=="Yes"){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Underwriting_Authority_Result']=="No"){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Underwriting_Authority_Result']=="N/A"){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Underwriting_Authority_Result" id="Underwriting_Authority_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Underwriting_Authority_Result";
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Underwriting_Authority_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor="";
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Underwriting_Authority_Score" id = "Underwriting_Authority_Score" value="<?php echo $opened['Underwriting_Authority_Score']?>"  placeholder="Underwriting_Authority_Score" readonly >
						<script>
							 $('#Underwriting_Authority_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Underwriting_Authority_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Underwriting_Authority_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Underwriting_Authority_Score').val('10');
								}else{
									$('#Underwriting_Authority_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control"  name="Underwriting_Authority_Observations" id="Underwriting_Authority_Observations"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $information_observation_type= array("Abeyances not appropriate in duration","Abeyances not closed when information received","Missing information not pursued and/or abeyance not set",
						"Other","Signatures received on endorsements where required","N/A") ?>
					
		
						<?php
						foreach ($information_observation_type as $key => $value):
						if($opened['Underwriting_Authority_Observations']== $value){
							echo '<option value="'.$value.'"selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Information_Gathering_Comments" name="Information_Gathering_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Information_Gathering_Comments'];?></textarea>						
				
					</div>
					<br>
					
				
				<!--Process-->	
				<div class="section">
						
						<label class="control-label" >Process: Standardized Process followed?</label>
						
						<br>
						<?php
						if ($opened['Process_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Process_Result']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Process_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
						
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Process_Result" id="Process_Result" style="background:<?php echo $bc;?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes"  <?php echo $r1?>>Yes</option>
						<option class="red" value= "No"  <?php echo $r2?>>No</option>
						<option class="" value= "N/A"  <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "Process_Result";
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Process_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							
							
							if (value != 0) {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor="";
										
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Process_Score" id = "Process_Score" value="<?php echo $opened['Process_Score'] ?>"  placeholder="Process_Score" readonly >
						<script>
							 $('#Process_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Process_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Process_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#Process_Score').val('10');
								} else{
									$('#Process_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Process_Observations" id="Process_Observations" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php $process_observation_type= array("Broker quoted – LIT not checked prior to issuing NB","Documentation guidelines not followed","Location address not entered in CGL c2 description",
					"Named insured is not a legal entity", "No notes in Energie", "Notes not including case numbers","Other", "Risk description should be amended to reflect the risk",
					"ServiceNow case was not categorized appropriately within defined standards","ServiceNow case was not classified appropriately","Standardized processes not followed","N/A") ?>
					
		
						<?php
						foreach ($process_observation_type as $key => $value):						
						if($opened['Process_Observations'] == $value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Process_Comments" name="Process_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Process_Comments'];?></textarea>						
				
					</div>
					<br>
					
					
					<!--Service-->	
				<div class="section">
						
						<label class="control-label" >Service: Was the file managed with the appropriate level of professionalism?</label>
						
						<br>
						<?php
						if ($opened['Service_Result']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['Service_Result']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['Service_Result']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
						if ($opened['Service_Result']=='Null'){$r0="selected";$bc=$white;}else{$r0="";};
												
						?>
						
						<label class="control-label">Result<span class="mandatory">***</span></label>
						<select class="reslut_selection" name="Service_Result" id="Service_Result" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" <?php echo $r0?>> Please Select</option>
						<option class="green" value= "Yes" data-price="10" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" data-price="0" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" data-price="10" <?php echo $r3?>>N/A</option>
						</select>
						
						
						<script>
						var elementId = "Service_Result";
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "Service_Result";
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						
						<input  type="hidden" class="form-control" type="text" name="Service_Score" id = "Service_Score" value = "<?php echo $opened['Service_Score'] ?>" placeholder="Service_Score" readonly >
						<script>
							 $('#Service_Result').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#Service_Score').val("10");
								} else if($(this).val()=="No"){//no
									$('#Service_Score').val('0');
								} else if($(this).val()=="N/A"){ //na
								$('#Service_Score').val('10');
								}else{
								$('#Service_Score').val('Null');
								}
							});  
						</script>
						
						<label class="control-label">Observation</label>
						
						<select class="form-control" name="Service_Observations" id="Service_Observations" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php $service_observation_type= array("Broker not advised of change in premium","Broker not advised of deviation from request","Broker was not advised of deviations to their request",
						"Broker was not advised of ineligible coverages","Broker was not notified of changes as requested","Communication not timely or relevant",
						"Ineligible coverage was not discussed with broker prior to issuance","Large premium discrepancies not discussed with broker prior to issuance","Other","N/A") ?>
		
						<?php
						foreach ($service_observation_type as $key => $value):						
						if($opened['Service_Observations'] == $value){
							echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="Service_Comments" name="Service_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Service_Comments'];?></textarea>						
				
					</div>
					<br>
			
<!--Summary-->	
					<div class="section">
						<h2 class ="form-group" for="title">Overall Score</h2>
						
						<input type="hidden" class="form-control" id="Overall_Score_Quantitative" name="Overall_Score_Quantitative" <?php echo $is_locked ;?> value = "<?php echo $opened['Overall_Score_Quantitative'];?>">					
						<textarea type="text"  class="form-control" rows="2"  style="font-size: 36px; text-align: center; padding-top:40px;vertical-align: middle;" id="Overall_Score_Qualitative" name="Overall_Score_Qualitative" <?php echo $is_locked ;?> ><?php echo $opened['Overall_Score_Qualitative'];?></textarea>						
						<script>
							if(!isNaN($('#Overall_Score_Quantitative').val())){
								if($('#Overall_Score_Quantitative').val()>=90){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $green?>";
								}else if($('#Overall_Score_Quantitative').val()>=75){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="yellow";
								}else{
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $red?>";
								}
							} 
																		
						
						</script>
						
						<script>
						  $('.reslut_selection').on("change",function(e){
							var score = [parseInt(document.getElementById('Risk_Assessment_Score').value),parseInt(document.getElementById("Data_Accuracy_Score").value),
										parseInt(document.getElementById("Rating_Score").value), parseInt(document.getElementById("Underwriting_Score").value),
										parseInt(document.getElementById("Information_Gathering_Score").value),parseInt(document.getElementById("Underwriting_Authority_Score").value),
										parseInt(document.getElementById("Process_Score").value) , parseInt(document.getElementById("Service_Score").value)]
							var sel = true;
							for (i = 0, len = score.length; i<len-1; i++){
								if(isNaN(score[i])){
									  sel = false;
									 
								}
							}
							if(sel == true){
								var total_score = parseInt(document.getElementById('Risk_Assessment_Score').value) + parseInt(document.getElementById("Data_Accuracy_Score").value) + parseInt(document.getElementById("Rating_Score").value) + 
								parseInt(document.getElementById("Underwriting_Score").value) + parseInt(document.getElementById("Information_Gathering_Score").value) + parseInt(document.getElementById("Underwriting_Authority_Score").value) + parseInt(document.getElementById("Process_Score").value) + parseInt(document.getElementById("Service_Score").value);
						
								$('#Overall_Score_Quantitative').val(total_score);
								}
							
							
								
							if(!isNaN($('#Overall_Score_Quantitative').val())){
								if($('#Overall_Score_Quantitative').val()>=90){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $green?>";
									document.getElementById('Overall_Score_Qualitative').value="Fully Achieved";
									
								}else if($('#Overall_Score_Quantitative').val()>=75){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="yellow";
									document.getElementById('Overall_Score_Qualitative').value="Partially Achieved";
								}else{
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $red?>";
									document.getElementById('Overall_Score_Qualitative').value="Immediate Action";
								}
							}
						
								
						})
						
						</script>
						
						
						<br>
						<label class="control-label">Action Required<span class="mandatory">***</span></label>
						
						<select class="form-control" name="Action_Required" id="Action_Required"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $action_type= array("Correction Required at Renewal","Correction Required Mid-Term: Immediate Action","N/A") ?>
		
						<?php
						foreach ($action_type as $key => $value):	
						if($opened['Action_Required']==$value){
							echo '<option value="'.$value.'"selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						<br>
						
						<label class="control-label">Action Status</label>
						<select  class="form-control" id="Action_Status" name="Action_Status">
						
						<option value="Completed" <?php if($opened['Action_Status']=="Completed"){echo "selected";}; ?>>Completed</option>
						<option value="N/A" <?php if($opened['Action_Status']!="Completed"){echo "selected";}; ?>>N/A</option>
						
						</select>
						
				
						<br>
						<label class="control-label"> Overall Comments </label>
						<textarea type="text"  class="form-control" rows="4" id="Overall_Comments" name="Overall_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Overall_Comments'];?></textarea>						
												
						<input type="hidden"  class="form-control"id="Date_Created" name="Date_Created" <?php echo $is_locked ;?> value = "<?php echo $opened['Date_Created'];?>" placeholder="Date Created">						
										
						<input type="hidden"  class="form-control"id="Date_Modified" name="Date_Modified" <?php echo $is_locked ;?> value = "<?php echo $opened['Date_Modified'];?>" placeholder="Date Modified">						
												
						<input type="hidden"  class="form-control" id="Created_By" name="Created_By" <?php echo $is_locked ;?>  value = "<?php echo $opened['Created_By'];?>" placeholder="Created_By">						
				
						<input type="hidden"  class="form-control"id="Modified_By" name="Modified_By" <?php echo $is_locked ;?> value = "<?php echo $opened['Modified_By'];?>" placeholder="Modified_By">						
				
				
					</div>
	<?php } else if ($review_template_type=="IRT"){?>
					<div class="section">
						
						<label class="control-label" >Data Accuracy: Information entered completely and correctly, as per the broker’s request.</label>
						
						<br>
						<?php
						if ($opened['POLICY_NUMBER_RESULT']=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
						if ($opened['POLICY_NUMBER_RESULT']=='No'){$r2="selected";$bc=$red;}else{$r2="";};
						if ($opened['POLICY_NUMBER_RESULT']=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
												
						?>
						
						<label class="control-label">Policy Number Result</label>
						<select class="reslut_selection" name="POLICY_NUMBER_RESULT" id="POLICY_NUMBER_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "POLICY_NUMBER_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "POLICY_NUMBER_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="POLICY_NUMBER_SCORE" id = "POLICY_NUMBER_SCORE" value = "<?php echo $opened['POLICY_NUMBER_SCORE'];?>" readonly >
						<script>
							 $('#POLICY_NUMBER_RESULT').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#POLICY_NUMBER_SCORE').val("5");
								} else if($(this).val()=="No"){//no
									$('#POLICY_NUMBER_SCORE').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#POLICY_NUMBER_SCORE').val('5');
								} else{
									$('#POLICY_NUMBER_SCORE').val('Null');
								}
							});  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="POLICY_NUMBER_COMMENTS" name="POLICY_NUMBER_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['POLICY_NUMBER_COMMENTS'];?></textarea>												
					
					<label class="control-label">Broker Code Result</label>
						<select class="reslut_selection" name="BROKER_CODE_RESULT" id="BROKER_CODE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "BROKER_CODE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "BROKER_CODE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="BROKER_CODE_SCORE" id = "BROKER_CODE_SCORE" value = "<?php echo $opened['BROKER_CODE_SCORE'];?>" readonly >
						<script>
							 $('#BROKER_CODE_RESULT').change(function(){
								if($(this).val()=="Yes"){ //yes
									$('#BROKER_CODE_SCORE').val("5");
								} else if($(this).val()=="No"){//no
									$('#BROKER_CODE_SCORE').val('0');
								} else if($(this).val()=="N/A"){ //na
									$('#BROKER_CODE_SCORE').val('5');
								} else{
									$('#BROKER_CODE_SCORE').val('Null');
								}
							});  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="BROKER_CODE_COMMENTS" name="BROKER_CODE_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['BROKER_CODE_COMMENTS'];?></textarea>												
					
					<label class="control-label">Policy Effective Date Result</label>
						<select class="reslut_selection"  name="POLICY_EFFECTIVE_DATE_RESULT" id="POLICY_EFFECTIVE_DATE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						var elementId = "POLICY_EFFECTIVE_DATE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "POLICY_EFFECTIVE_DATE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="POLICY_EFFECTIVE_DATE_SCORE" id = "POLICY_EFFECTIVE_DATE_SCORE" value = "<?php echo $opened['POLICY_EFFECTIVE_DATE_SCORE'];?>" readonly >
						<script type="text/javascript">
							$('#POLICY_EFFECTIVE_DATE_RESULT').change(function(){
						var score_id = "POLICY_EFFECTIVE_DATE_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 5;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 5;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						});
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="POLICY_EFFECTIVE_DATE_COMMENTS" name="POLICY_EFFECTIVE_DATE_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['POLICY_EFFECTIVE_DATE_COMMENTS'];?></textarea>												
					
					
					<label class="control-label">Named Insured Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="NAMED_INSURED_RESULT" id="NAMED_INSURED_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
						function scoreChange(){
							
							alert("hello. change score");
						}
						
						
						var elementId = "NAMED_INSURED_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "NAMED_INSURED_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="NAMED_INSURED_SCORE" id = "NAMED_INSURED_SCORE" value = "<?php echo $opened['NAMED_INSURED_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#NAMED_INSURED_RESULT').change(function(){
								var score_id = "NAMED_INSURED_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 5;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 5;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="NAMED_INSURED_COMMENTS" name="NAMED_INSURED_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['NAMED_INSURED_COMMENTS'];?></textarea>												
					</div>
					<br>
				
			<div class="section">
					<label class= "control-label"> Categorization:File was correctly categorized. </label>
					<br>
					<label class="control-label">Transaction Type Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="TRANSACTION_TYPE_RESULT" id="TRANSACTION_TYPE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "TRANSACTION_TYPE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "TRANSACTION_TYPE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="TRANSACTION_TYPE_SCORE" id = "TRANSACTION_TYPE_SCORE" value = "<?php echo $opened['TRANSACTION_TYPE_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#TRANSACTION_TYPE_RESULT').change(function(){
								var score_id = "TRANSACTION_TYPE_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 10;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 10;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="TRANSACTION_TYPE_COMMENTS" name="TRANSACTION_TYPE_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['TRANSACTION_TYPE_COMMENTS'];?></textarea>												
					
					<br>
					<label class="control-label">Line of Business Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="LINE_OF_BUSINESS_RESULT" id="LINE_OF_BUSINESS_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "LINE_OF_BUSINESS_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "LINE_OF_BUSINESS_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="LINE_OF_BUSINESS_SCORE" id = "LINE_OF_BUSINESS_SCORE" value = "<?php echo $opened['LINE_OF_BUSINESS_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#LINE_OF_BUSINESS_RESULT').change(function(){
								var score_id = "LINE_OF_BUSINESS_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 10;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 10;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="TLINE_OF_BUSINESS_COMMENTS" name="LINE_OF_BUSINESS_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['LINE_OF_BUSINESS_COMMENTS'];?></textarea>												
					<br>
					<label class="control-label">Risk Type Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="RISK_TYPE_RESULT" id="RISK_TYPE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "RISK_TYPE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "RISK_TYPE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="RISK_TYPE_SCORE" id = "RISK_TYPE_SCORE" value = "<?php echo $opened['RISK_TYPE_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#RISK_TYPE_RESULT').change(function(){
								var score_id = "RISK_TYPE_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 10;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 10;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="LINE_OF_BUSINESS_COMMENTS" name="LINE_OF_BUSINESS_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['LINE_OF_BUSINESS_COMMENTS'];?></textarea>												
					
					<br>
					<label class="control-label">Authority Level Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="AUTHORITY_LEVEL_RESULT" id="AUTHORITY_LEVEL_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "AUTHORITY_LEVEL_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "AUTHORITY_LEVEL_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="AUTHORITY_LEVEL_SCORE" id = "AUTHORITY_LEVEL_SCORE" value = "<?php echo $opened['AUTHORITY_LEVEL_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#AUTHORITY_LEVEL_RESULT').change(function(){
								var score_id = "AUTHORITY_LEVEL_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 10;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 10;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="AUTHORITY_LEVEL_COMMENTS" name="AUTHORITY_LEVEL_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['AUTHORITY_LEVEL_COMMENTS'];?></textarea>												
							
					</div>
					<br>
					<div class="section">
					<label class="control-label">Process:As required</label>
					<br>
					
					<label class="control-label">Market Reservation (Commercial Intake Only) Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="MARKET_RESERVATION_RESULT" id="MARKET_RESERVATION_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "MARKET_RESERVATION_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "MARKET_RESERVATION_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="MARKET_RESERVATION_SCORE" id = "MARKET_RESERVATION_SCORE" value = "<?php echo $opened['MARKET_RESERVATION_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#MARKET_RESERVATION_RESULT').change(function(){
								var score_id = "MARKET_RESERVATION_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 15;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 15;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="MARKET_RESERVATION_COMMENTS" name="MARKET_RESERVATION_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['MARKET_RESERVATION_COMMENTS'];?></textarea>												
						
						<br>
						<label class="control-label">Identification of Express and Mid-Market Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT" id="IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE" id = "IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE" value = "<?php echo $opened['IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT').change(function(){
								var score_id = "IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 15;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 15;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS" name="IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS'];?></textarea>												
						<br>
						
						<label class="control-label">Selected the Correct Broker Code Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="SELECTED_THE_CORRECT_BROKER_CODE_RESULT" id="SELECTED_THE_CORRECT_BROKER_CODE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "SELECTED_THE_CORRECT_BROKER_CODE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "SELECTED_THE_CORRECT_BROKER_CODE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="SELECTED_THE_CORRECT_BROKER_CODE_SCORE" id = "SELECTED_THE_CORRECT_BROKER_CODE_SCORE" value = "<?php echo $opened['SELECTED_THE_CORRECT_BROKER_CODE_SCORE'];?>" readonly >
						<script type="text/javascript">
							 $('#SELECTED_THE_CORRECT_BROKER_CODE_RESULT').change(function(){
								var score_id = "SELECTED_THE_CORRECT_BROKER_CODE_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 5;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 5;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS" name="SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS'];?></textarea>												
						
						<br>
						<label class="control-label">Followed Exception Process where Applicable Result</label>
						<select class="reslut_selection" onchange="scoreChange()" name="FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT" id="FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  >
						<option value= "Null" > Please Select</option>
						<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
						<option class="red" value= "No" <?php echo $r2?>>No</option>
						<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
						</select>
						
						<script>
												
						var elementId = "FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT"
						var classNumber = document.getElementById(elementId);
						classNumber.onchange = runBackgroundChange;

						function runBackgroundChange(first){
							var elementId = "FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT"
							var value = first.srcElement.options[first.srcElement.selectedIndex].value;
							if (value != "Null") {
								
								if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
								if(value=="No")
									document.getElementById(elementId).style.backgroundColor=red;
								if(value=="N/A")
									document.getElementById(elementId).style.backgroundColor=white;
								
							
							} else {
								document.getElementById(elementId).style.backgroundColor="";
							};
						}
						</script>
						<input  type="" class="form-control" type="text" name="FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE" id = "FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE" value = "<?php echo $opened['FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE']?>" >
						<script type="text/javascript">
							 $('#FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT').change(function(){
								var score_id = "FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE";
						
								if($(this).val()=="Yes"){ //yes
									document.getElementById(score_id).value = 5;
								} else if($(this).val()=="No"){//no
									document.getElementById(score_id).value = 0;
								} else if($(this).val()=="N/A"){ //na
									document.getElementById(score_id).value = 5;
								} else{
									document.getElementById(score_id).value = 'Null';
								}
						}); 
						  
						</script>
												
						<label class="control-label">Comments</label>
						<textarea type="text"  class="form-control" rows="4" id="FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS" name="FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS" <?php echo $is_locked ;?> ><?php echo $opened['FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS'];?></textarea>												
						<br>
						
					</div>
					
					
					<div class="section">
						<h2 class ="form-group" for="title">Overall Score</h2>
						
						<input type="" class="form-control" id="Overall_Score_Quantitative" name="Overall_Score_Quantitative" <?php echo $is_locked ;?> value = "<?php echo $opened['OVERALL_SCORE_QUANTITATIVE'];?>">					
						<textarea type="text"  class="form-control" rows="2"  style="font-size: 36px; text-align: center; padding-top:40px;vertical-align: middle;" id="Overall_Score_Qualitative" name="Overall_Score_Qualitative" <?php echo $is_locked ;?> ><?php echo $opened['Overall_Score_Qualitative'];?></textarea>						
						<script>
							if(!isNaN($('#Overall_Score_Quantitative').val())){
								if($('#Overall_Score_Quantitative').val()>=98){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $green?>";
								}else if($('#Overall_Score_Quantitative').val()>=85){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="yellow";
								}else{
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $red?>";
								}
							} 
																		
						
						</script>
						
						<script>
						  $('.reslut_selection').on("change",function(e){
							  console.log("selection change");
							var score = [parseInt(document.getElementById('POLICY_NUMBER_SCORE').value),parseInt(document.getElementById("BROKER_CODE_SCORE").value),
										parseInt(document.getElementById("POLICY_EFFECTIVE_DATE_SCORE").value), parseInt(document.getElementById("NAMED_INSURED_SCORE").value),
										parseInt(document.getElementById("TRANSACTION_TYPE_SCORE").value),parseInt(document.getElementById("LINE_OF_BUSINESS_SCORE").value),
										parseInt(document.getElementById("RISK_TYPE_SCORE").value) , parseInt(document.getElementById("AUTHORITY_LEVEL_SCORE").value),
										parseInt(document.getElementById("MARKET_RESERVATION_SCORE").value), parseInt(document.getElementById("IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE").value),
										parseInt(document.getElementById("SELECTED_THE_CORRECT_BROKER_CODE_SCORE").value), parseInt(document.getElementById("FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE").value)]
							var sel = true;
							function add(a, b) {
								return a + b;
						  }
							for (i = 0, len = score.length; i<len-1; i++){
								if(isNaN(score[i])){
									  sel = false;
									 
								}
							}
							if(sel == true){
								var total_score = score.reduce(add,0);
								
								$('#Overall_Score_Quantitative').val(total_score);
								}
							
														
							if(!isNaN($('#Overall_Score_Quantitative').val())){
								if($('#Overall_Score_Quantitative').val()>=98){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $green?>";
									document.getElementById('Overall_Score_Qualitative').value="Fully Achieved";
									
								}else if($('#Overall_Score_Quantitative').val()>=85){
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="yellow";
									document.getElementById('Overall_Score_Qualitative').value="Partially Achieved";
								}else{
									document.getElementById('Overall_Score_Qualitative').style.backgroundColor="<?php echo $red?>";
									document.getElementById('Overall_Score_Qualitative').value="Immediate Action";
								}
							}
						
								
						})
						
						</script>
						
						
						<br>
						<label class="control-label">Action Required</label>
						
						<select class="form-control" name="Action_Required" id="Action_Required"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
						
						<option value= "Null" > Please Select</option>
						<?php $action_type= array("Correction Required at Renewal","Correction Required Mid-Term: Immediate Action","N/A") ?>
		
						<?php
						foreach ($action_type as $key => $value):	
						if($opened['ACTION_REQUIRED']==$value){
							echo '<option value="'.$value.'"selected>'.$value.'</option>'; //close your tags!!
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
						}
						
						endforeach;
													
						?>
						</select>
						<br>
						
						<label class="control-label">Action Status</label>
						<select  class="form-control" id="Action_Status" name="Action_Status">
						
						<option value="Completed" <?php if($opened['ACTION_STATUS']=="Completed"){echo "selected";}; ?>>Completed</option>
						<option value="N/A" <?php if($opened['ACTION_STATUS']!="Completed"){echo "selected";}; ?>>N/A</option>
						
						</select>
						
				
						<br>
						<label class="control-label"> Overall Comments </label>
						<textarea type="text"  class="form-control" rows="4" id="Overall_Comments" name="Overall_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Overall_Comments'];?></textarea>						
												
						<input type="hidden"  class="form-control"id="Date_Created" name="Date_Created" <?php echo $is_locked ;?> value = "<?php echo $opened['Date_Created'];?>" placeholder="Date Created">						
										
						<input type="hidden"  class="form-control"id="Date_Modified" name="Date_Modified" <?php echo $is_locked ;?> value = "<?php echo $opened['Date_Modified'];?>" placeholder="Date Modified">						
												
						<input type="hidden"  class="form-control" id="Created_By" name="Created_By" <?php echo $is_locked ;?>  value = "<?php echo $opened['Created_By'];?>" placeholder="Created_By">						
				
						<input type="hidden"  class="form-control"id="Modified_By" name="Modified_By" <?php echo $is_locked ;?> value = "<?php echo $opened['Modified_By'];?>" placeholder="Modified_By">						
				
				
					</div>
					
					
	
	<?php }?>
					<br>
					<button type="submit" name="submitted" class="btn btn-default">Save</button>
					<script>
					
						  $("#main_form").submit( function(e) {
							  var select_tl_name = $("#Team_Leader option:selected").text().trim();
							 $('#Team_Leader_hidden_name').val(select_tl_name) ;
							 
							 var select_assigned_to_name = $("#Assigned_To option:selected").text().trim();
							 $('#Assigned_To_hidden_name').val(select_assigned_to_name) ;
							 
							 var select_reviewed_by_name = $("#Reviewed_By option:selected").text().trim();
							 $('#Reviewed_By_hidden_name').val(select_reviewed_by_name) ;
							 
							
							var score = [parseInt(document.getElementById('Risk_Assessment_Score').value),parseInt(document.getElementById("Data_Accuracy_Score").value),
										parseInt(document.getElementById("Rating_Score").value), parseInt(document.getElementById("Underwriting_Score").value),
										parseInt(document.getElementById("Information_Gathering_Score").value),parseInt(document.getElementById("Underwriting_Authority_Score").value),
										parseInt(document.getElementById("Process_Score").value) , parseInt(document.getElementById("Service_Score").value)]
							for (i = 0, len = score.length; i<len; i++){
								if(isNaN(score[i])){
									alert ("Please select rating in each fields")
									 return false;
								}else{
								var total_score = parseInt(document.getElementById('Risk_Assessment_Score').value) + parseInt(document.getElementById("Data_Accuracy_Score").value) + parseInt(document.getElementById("Rating_Score").value) + 
								parseInt(document.getElementById("Underwriting_Score").value) + parseInt(document.getElementById("Information_Gathering_Score").value) + parseInt(document.getElementById("Underwriting_Authority_Score").value) + parseInt(document.getElementById("Process_Score").value) + parseInt(document.getElementById("Service_Score").value);
						
								$('#Overall_Score_Quantitative').val(total_score);
								console.log("service result score is: ", total_score);	
								}
							}
							
							  var mandatory_fields = ["Assigned_To","Team_Leader","Reviewed_By","Review_Type","Case_Number","Transaction_Type","Action_Required"]
							for (j =0; j < mandatory_fields.length; j++){
								if (document.getElementById(mandatory_fields[j]).value=="Null"){
									alert ("Please fill all madatory fields before submitting!")
									 return false;
								}else { console.log ("field ", mandatory_fields[j]," was filled")}
							} 
							  
							 //alert($("#Assigned_To OPTION[VALUE='SHZ']").text().trim());
							 
						  });
					</script>
					
		</form>
	</div>
	</div>	
		<?php// }?>	
		
		<div class= "col-md-3" id="sidebar">
		<form name = "seach_panel" action="index.php"  method = "POST">
			<div class ="list-group">
				
			<a class ="list-group-item" id="add_trt" name="add_trt"   href = "index.php?review_template=TRT" style="background-color:#E6E6FA">
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Transactional Review</h4>
			</a>
			<a class ="list-group-item" id="add_irt" name="add_irt"   href = "index.php?review_template=IRT" style="background-color:#E6E6FA">			
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Intake Review</h4>
			</a>
			<a class ="list-group-item" id="add_crt" name="add_crt"  href = "index.php?review_template=CRT" style="background-color:#E6E6FA">			
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Call Review</h4>
	       </a>	
			</div>
			<script>
			/* function SetReviewType(pID){
				if(pID=='add_trt'){
					$('#review_template').val("TRT")
				} else if (pID = 'add_irt'){
					$('#review_template').val("IRT")
				} else if(pID = 'add_crt'){
					$('#review_template').val("CRT")
				}
			} */
			</script>
			
			<?php
				
			
				if(isset($_POST['submitted'])==1){
				
				/* if ($_POST['agree_text']=="true"){
						$agree=mysqli_real_escape_string($dbc, "1");
				}else{
					$agree=mysqli_real_escape_string($dbc, "0");
				} */
				$ID= mysqli_real_escape_string($dbc, $_POST['ID']);
				$Assigned_To= mysqli_real_escape_string($dbc, $_POST['Assigned_To']);
				$Assigned_To_hidden_name= mysqli_real_escape_string($dbc, $_POST['Assigned_To_hidden_name']);
				
				$AT_TCH= mysqli_real_escape_string($dbc, $_POST['AT_TCH']);
				$Team_Leader= mysqli_real_escape_string($dbc, $_POST['Team_Leader']);
				$Team_Leader_hidden_name= mysqli_real_escape_string($dbc, $_POST['Team_Leader_hidden_name']);
				
				
				$TL_TCH= mysqli_real_escape_string($dbc, $_POST['TL_TCH']);
				$Reviewed_By= mysqli_real_escape_string($dbc, $_POST['Reviewed_By']);
				$Reviewed_By_hidden_name= mysqli_real_escape_string($dbc, $_POST['Reviewed_By_hidden_name']);
				
				$RB_TCH = mysqli_real_escape_string($dbc, $_POST['RB_TCH']);
				$Review_Type = mysqli_real_escape_string($dbc, $_POST['Review_Type']);
				$Review_Month = mysqli_real_escape_string($dbc, $_POST['Review_Month']);
				
				
				$Case_Number = mysqli_real_escape_string($dbc, $_POST['Case_Number']);
				$Policy_Number = mysqli_real_escape_string($dbc, $_POST['Policy_Number']);
				$Region = mysqli_real_escape_string($dbc, $_POST['Region']);
				$Transaction_Type = mysqli_real_escape_string($dbc, $_POST['Transaction_Type']);
				$Line_of_Business = mysqli_real_escape_string($dbc, $_POST['Line_of_Business']);
				$Effective_Date = mysqli_real_escape_string($dbc, $_POST['Effective_Date']);
				
				$Risk_Assessment_Result = mysqli_real_escape_string($dbc, $_POST['Risk_Assessment_Result']);
				$Risk_Assessment_Observations = mysqli_real_escape_string($dbc, $_POST['Risk_Assessment_Observations']);
				$Risk_Assessment_Comments = mysqli_real_escape_string($dbc, $_POST['Risk_Assessment_Comments']);
				$Risk_Assessment_Score = mysqli_real_escape_string($dbc, $_POST['Risk_Assessment_Score']);
				
				$Data_Accuracy_Result = mysqli_real_escape_string($dbc, $_POST['Data_Accuracy_Result']);
				$Data_Accuracy_Observations = mysqli_real_escape_string($dbc, $_POST['Data_Accuracy_Observations']);
				$Data_Accuracy_Comments = mysqli_real_escape_string($dbc, $_POST['Data_Accuracy_Comments']);
				$Data_Accuracy_Score = mysqli_real_escape_string($dbc, $_POST['Data_Accuracy_Score']);
				
				$Rating_Result = mysqli_real_escape_string($dbc, $_POST['Rating_Result']);
				$Rating_Observations = mysqli_real_escape_string($dbc, $_POST['Rating_Observations']);
				$Rating_Comments = mysqli_real_escape_string($dbc, $_POST['Rating_Comments']);
				$Rating_Score = mysqli_real_escape_string($dbc, $_POST['Rating_Score']);
				
				$Underwriting_Result = mysqli_real_escape_string($dbc, $_POST['Underwriting_Result']);
				$Underwriting_Observations = mysqli_real_escape_string($dbc, $_POST['Underwriting_Observations']);
				$Underwriting_Comments = mysqli_real_escape_string($dbc, $_POST['Underwriting_Comments']);
				$Underwriting_Score = mysqli_real_escape_string($dbc, $_POST['Underwriting_Score']);
				
				$Information_Gathering_Result = mysqli_real_escape_string($dbc, $_POST['Information_Gathering_Result']);
				$Information_Gathering_Observations = mysqli_real_escape_string($dbc, $_POST['Information_Gathering_Observations']);
				$Information_Gathering_Comments = mysqli_real_escape_string($dbc, $_POST['Information_Gathering_Comments']);
				$Information_Gathering_Score = mysqli_real_escape_string($dbc, $_POST['Information_Gathering_Score']);
				
				$Underwriting_Authority_Result = mysqli_real_escape_string($dbc, $_POST['Underwriting_Authority_Result']);
				$Underwriting_Authority_Observations = mysqli_real_escape_string($dbc, $_POST['Underwriting_Authority_Observations']);
				$Underwriting_Authority_Comments = mysqli_real_escape_string($dbc, $_POST['Underwriting_Authority_Comments']);
				$Underwriting_Authority_Score = mysqli_real_escape_string($dbc, $_POST['Underwriting_Authority_Score']);
				
				$Process_Result = mysqli_real_escape_string($dbc, $_POST['Process_Result']);
				$Process_Observations = mysqli_real_escape_string($dbc, $_POST['Process_Observations']);
				$Process_Comments = mysqli_real_escape_string($dbc, $_POST['Process_Comments']);
				$Process_Score = mysqli_real_escape_string($dbc, $_POST['Process_Score']);
				
				$Service_Result = mysqli_real_escape_string($dbc, $_POST['Service_Result']);
				$Service_Observations = mysqli_real_escape_string($dbc, $_POST['Service_Observations']);
				$Service_Comments = mysqli_real_escape_string($dbc, $_POST['Service_Comments']);
				$Service_Score = mysqli_real_escape_string($dbc, $_POST['Service_Score']);
				
				$Overall_Score_Quantitative = mysqli_real_escape_string($dbc, $_POST['Overall_Score_Quantitative']);
				$Overall_Score_Qualitative = mysqli_real_escape_string($dbc, $_POST['Overall_Score_Qualitative']);
				
				$date = date('Y-m-d H:i:s');
				$Date_Created = mysqli_real_escape_string($dbc, $date); 
				$Created_By = mysqli_real_escape_string($dbc, $_SESSION[username]);
				
				$Date_Modified = mysqli_real_escape_string($dbc, $date);
				$Modified_By = mysqli_real_escape_string($dbc, $_SESSION[username]);
				
				
				$Action_Required = mysqli_real_escape_string($dbc, $_POST['Action_Required']);
				$Action_Status = mysqli_real_escape_string($dbc, $_POST['Action_Status']);
				$Overall_Comments = mysqli_real_escape_string($dbc, $_POST['Overall_Comments']);
				
	##### IRT 
				$ID= mysqli_real_escape_string($dbc, $_POST['ID']);
				$Assigned_To= mysqli_real_escape_string($dbc, $_POST['Assigned_To']);
				$Assigned_To_hidden_name= mysqli_real_escape_string($dbc, $_POST['Assigned_To_hidden_name']);
				
				$AT_TCH= mysqli_real_escape_string($dbc, $_POST['AT_TCH']);
				$Team_Leader= mysqli_real_escape_string($dbc, $_POST['Team_Leader']);
				$Team_Leader_hidden_name= mysqli_real_escape_string($dbc, $_POST['Team_Leader_hidden_name']);
				
				
				$TL_TCH= mysqli_real_escape_string($dbc, $_POST['TL_TCH']);
				$Reviewed_By= mysqli_real_escape_string($dbc, $_POST['Reviewed_By']);
				$Reviewed_By_hidden_name= mysqli_real_escape_string($dbc, $_POST['Reviewed_By_hidden_name']);
				
				$RB_TCH = mysqli_real_escape_string($dbc, $_POST['RB_TCH']);
				$Review_Type = mysqli_real_escape_string($dbc, $_POST['Review_Type']);
				//$Review_Month = mysqli_real_escape_string($dbc, $_POST['Review_Month']);
				
				
				$Case_Number = mysqli_real_escape_string($dbc, $_POST['Case_Number']);
				//$Policy_Number = mysqli_real_escape_string($dbc, $_POST['Policy_Number']);
				$Region 		                                = mysqli_real_escape_string($dbc, $_POST['Region']);
				$Transaction_Type                               = mysqli_real_escape_string($dbc, $_POST['Transaction_Type']);
				$Line_of_Business                               = mysqli_real_escape_string($dbc, $_POST['Line_of_Business']);
				$Effective_Date                                 = mysqli_real_escape_string($dbc, $_POST['Effective_Date']);
				
				$POLICY_NUMBER_RESULT 							= mysqli_real_escape_string($dbc, $_POST['POLICY_NUMBER_RESULT']);
				$POLICY_EFFECTIVE_DATE_RESULT					= mysqli_real_escape_string($dbc, $_POST['POLICY_EFFECTIVE_DATE_RESULT']);
				$BROKER_CODE_RESULT								= mysqli_real_escape_string($dbc, $_POST['BROKER_CODE_RESULT']);
				$NAMED_INSURED_RESULT                           = mysqli_real_escape_string($dbc, $_POST['NAMED_INSURED_RESULT']);
				$TRANSACTION_TYPE_RESULT                        = mysqli_real_escape_string($dbc, $_POST['TRANSACTION_TYPE_RESULT']);
				$LINE_OF_BUSINESS_RESULT                        = mysqli_real_escape_string($dbc, $_POST['LINE_OF_BUSINESS_RESULT']);
				$RISK_TYPE_RESULT                               = mysqli_real_escape_string($dbc, $_POST['RISK_TYPE_RESULT']);
				$AUTHORITY_LEVEL_RESULT                         = mysqli_real_escape_string($dbc, $_POST['AUTHORITY_LEVEL_RESULT']);
				$MARKET_RESERVATION_RESULT                      = mysqli_real_escape_string($dbc, $_POST['MARKET_RESERVATION_RESULT']);
				$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT = mysqli_real_escape_string($dbc, $_POST['IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT']);
				$SELECTED_THE_CORRECT_BROKER_CODE_RESULT        = mysqli_real_escape_string($dbc, $_POST['SELECTED_THE_CORRECT_BROKER_CODE_RESULT']);
				$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT= mysqli_real_escape_string($dbc, $_POST['FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT']);
				$POLICY_NUMBER_COMMENTS                         = mysqli_real_escape_string($dbc, $_POST['POLICY_NUMBER_COMMENTS']);
				$BROKER_CODE_COMMENTS                           = mysqli_real_escape_string($dbc, $_POST['BROKER_CODE_COMMENTS']);
				$POLICY_EFFECTIVE_DATE_COMMENTS                 = mysqli_real_escape_string($dbc, $_POST['POLICY_EFFECTIVE_DATE_COMMENTS']);
				$NAMED_INSURED_COMMENTS                         = mysqli_real_escape_string($dbc, $_POST['NAMED_INSURED_COMMENTS']);
				$TRANSACTION_TYPE_COMMENTS                      = mysqli_real_escape_string($dbc, $_POST['TRANSACTION_TYPE_COMMENTS']);
				$LINE_OF_BUSINESS_COMMENTS                      = mysqli_real_escape_string($dbc, $_POST['LINE_OF_BUSINESS_COMMENTS']);
				$RISK_TYPE_COMMENTS                             = mysqli_real_escape_string($dbc, $_POST['RISK_TYPE_COMMENTS']);
				$AUTHORITY_LEVEL_COMMENTS                       = mysqli_real_escape_string($dbc, $_POST['AUTHORITY_LEVEL_COMMENTS']);
				$MARKET_RESERVATION_COMMENTS                    = mysqli_real_escape_string($dbc, $_POST['MARKET_RESERVATION_COMMENTS']);
				$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS= mysqli_real_escape_string($dbc, $_POST['IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS']);
				$SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS      = mysqli_real_escape_string($dbc, $_POST['SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS']);
				$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS= mysqli_real_escape_string($dbc, $_POST['FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS']);
				$POLICY_NUMBER_SCORE                            = mysqli_real_escape_string($dbc, $_POST['POLICY_NUMBER_SCORE']);
				$BROKER_CODE_SCORE                              = mysqli_real_escape_string($dbc, $_POST['BROKER_CODE_SCORE']);
				$POLICY_EFFECTIVE_DATE_SCORE                    = mysqli_real_escape_string($dbc, $_POST['POLICY_EFFECTIVE_DATE_SCORE']);
				$NAMED_INSURED_SCORE                            = mysqli_real_escape_string($dbc, $_POST['NAMED_INSURED_SCORE']);
				$TRANSACTION_TYPE_SCORE                         = mysqli_real_escape_string($dbc, $_POST['TRANSACTION_TYPE_SCORE']);
				$LINE_OF_BUSINESS_SCORE                         = mysqli_real_escape_string($dbc, $_POST['LINE_OF_BUSINESS_SCORE']);
				$RISK_TYPE_SCORE                                = mysqli_real_escape_string($dbc, $_POST['RISK_TYPE_SCORE']);
				$AUTHORITY_LEVEL_SCORE                          = mysqli_real_escape_string($dbc, $_POST['AUTHORITY_LEVEL_SCORE']);
				$MARKET_RESERVATION_SCORE                       = mysqli_real_escape_string($dbc, $_POST['MARKET_RESERVATION_SCORE']);
				$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE  = mysqli_real_escape_string($dbc, $_POST['IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE']);
				$SELECTED_THE_CORRECT_BROKER_CODE_SCORE         = mysqli_real_escape_string($dbc, $_POST['SELECTED_THE_CORRECT_BROKER_CODE_SCORE']);
				$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE= mysqli_real_escape_string($dbc, $_POST['FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE']);


				$OVERALL_SCORE_QUANTITATIVE = mysqli_real_escape_string($dbc, $_POST['Overall_Score_Quantitative']);
				$OVERALL_SCORE_QUALITATIVE = mysqli_real_escape_string($dbc, $_POST['Overall_Score_Qualitative']);
				
				$date = date('Y-m-d H:i:s');
				$DATE_CREATED = mysqli_real_escape_string($dbc, $date); 
				$CREATED_BY = mysqli_real_escape_string($dbc, $_SESSION[username]);
				
				$DATE_MODIFIED = mysqli_real_escape_string($dbc, $date);
				$MODIFIED_BY = mysqli_real_escape_string($dbc, $_SESSION[username]);
				
				
				$ACTION_REQUIRED = mysqli_real_escape_string($dbc, $_POST['Action_Required']);
				$ACTION_STATUS = mysqli_real_escape_string($dbc, $_POST['Action_Status']);
				$OVERALL_COMMENTS = mysqli_real_escape_string($dbc, $_POST['Overall_Comments']);

	### IRT END	
				
				
				if (isset($_POST['ID']) && is_numeric($_POST['ID'])){
					error_log(" in trur branch, The page id in id field is: ".$_POST['ID']);
					error_log(" review template is: ". $review_template_type);
					if($review_template_type=="TRT"){
					/* if(isset($_POST['review_template'])){
						if($_POST['review_template']=="TRT"){ */
							$q = "UPDATE transactionalreviewtable SET 
								Assigned_To = '$Assigned_To_hidden_name',
								AT_TCH = '$AT_TCH',
								Team_Leader = '$Team_Leader_hidden_name',
								TL_TCH ='$TL_TCH',
								Reviewed_By = '$Reviewed_By_hidden_name' ,
								RB_TCH ='$RB_TCH' ,
								Review_Type = '$Review_Type',
								Review_Month ='$Review_Month',
								Case_Number = '$Case_Number',
								Policy_Number = '$Policy_Number' ,
								Region ='$Region',
								Transaction_Type ='$Transaction_Type' ,
								Line_of_Business ='$Line_of_Business' ,
								Effective_Date ='$Effective_Date' ,
								Risk_Assessment_Result = '$Risk_Assessment_Result' ,
								Risk_Assessment_Observations = '$Risk_Assessment_Observations' ,
								Risk_Assessment_Comments = '$Risk_Assessment_Comments',
								Risk_Assessment_Score ='$Risk_Assessment_Score',
								Data_Accuracy_Result ='$Data_Accuracy_Result' ,
								Data_Accuracy_Observations ='$Data_Accuracy_Observations' ,
								Data_Accuracy_Comments ='$Data_Accuracy_Comments' ,
								Data_Accuracy_Score ='$Data_Accuracy_Score' ,
								Rating_Result ='$Rating_Result' ,
								Rating_Observations ='$Rating_Observations' ,
								Rating_Comments = '$Rating_Comments',
								Rating_Score ='$Rating_Score' ,
								Underwriting_Result ='$Underwriting_Result' ,
								Underwriting_Observations ='$Underwriting_Observations' ,
								Underwriting_Comments ='$Underwriting_Comments',
								Underwriting_Score ='$Underwriting_Score',
								Information_Gathering_Result ='$Information_Gathering_Result',
								Information_Gathering_Observations ='$Information_Gathering_Observations',
								Information_Gathering_Comments ='$Information_Gathering_Comments',
								Information_Gathering_Score = '$Information_Gathering_Score',
								Underwriting_Authority_Result ='$Underwriting_Authority_Result' ,
								Underwriting_Authority_Observations ='$Underwriting_Authority_Observations' ,
								Underwriting_Authority_Comments ='$Underwriting_Authority_Comments' ,
								Underwriting_Authority_Score ='$Underwriting_Authority_Score',
								Process_Result ='$Process_Result',
								Process_Observations ='$Process_Observations' ,
								Process_Comments ='$Process_Observations' ,
								Process_Score ='$Process_Score' ,
								Service_Result ='$Service_Result',
								Service_Observations ='$Service_Observations' ,
								Service_Score ='$Service_Score', 
								Service_Comments ='$Service_Comments' ,
								Overall_Score_Quantitative ='$Overall_Score_Quantitative',
								Overall_Score_Qualitative ='$Overall_Score_Qualitative',
								Date_Created ='$Date_Created', 
								Created_By = '$Created_By', 
								Date_Modified = '$Date_Modified',
								Modified_By='$Modified_By', 
								Action_Required='$Action_Required', 
								Action_Status = '$Action_Status', 
								Overall_Comments ='$Overall_Comments' WHERE ID=$_POST[ID]";
						//}
					}else if($review_template_type=="IRT"){
						
					}
							
				}/*else it is new record*/else {
					error_log("In else branch: The page id in id field is: ".$_POST['ID']);
						if($review_template_type=="TRT"){
						$q = "INSERT transactionalreviewtable (
								Assigned_To,
								AT_TCH,
								Team_Leader,
								TL_TCH,
								Reviewed_By,
								
								RB_TCH ,
								Review_Type ,
								Review_Month ,
								
								
								Case_Number,
								Policy_Number ,
								Region ,
								Transaction_Type ,
								Line_of_Business ,
								Effective_Date ,
								
								Risk_Assessment_Result ,
								Risk_Assessment_Observations ,
								Risk_Assessment_Comments,
								Risk_Assessment_Score ,
								
								Data_Accuracy_Result ,
								Data_Accuracy_Observations ,
								Data_Accuracy_Comments ,
								Data_Accuracy_Score ,
								
								Rating_Result ,
								Rating_Observations ,
								Rating_Comments ,
								Rating_Score ,
								
								Underwriting_Result ,
								Underwriting_Observations ,
								Underwriting_Comments ,
								Underwriting_Score,
								
								Information_Gathering_Result ,
								Information_Gathering_Observations ,
								Information_Gathering_Comments ,
								Information_Gathering_Score,
								
								Underwriting_Authority_Result ,
								Underwriting_Authority_Observations ,
								Underwriting_Authority_Comments ,
								Underwriting_Authority_Score,
					
								Process_Result ,
								Process_Observations ,
								Process_Comments ,
								Process_Score ,
								
								Service_Result,
								Service_Observations ,
								Service_Score, 
						
								Overall_Score_Quantitative,
								Overall_Score_Qualitative,
								
								Date_Created, 
								Created_By, 
								Date_Modified,
								Modified_By, 
								Action_Required, 
								Action_Status, 
								Overall_Comments)
						
					
								VALUES (
								'$Assigned_To_hidden_name',
								'$AT_TCH',
								'$Team_Leader_hidden_name',
								'$TL_TCH',
								'$Reviewed_By_hidden_name',
								
								'$RB_TCH' ,
								'$Review_Type' ,
								'$Review_Month' ,
							
								'$Case_Number',
								'$Policy_Number' ,
								'$Region' ,
								'$Transaction_Type' ,
								'$Line_of_Business' ,
								'$Effective_Date' ,
							
								'$Risk_Assessment_Result' ,
								'$Risk_Assessment_Observations' ,
								'$Risk_Assessment_Comments',
								'$Risk_Assessment_Score' ,
								
								'$Data_Accuracy_Result' ,
								'$Data_Accuracy_Observations' ,
								'$Data_Accuracy_Comments' ,
								'$Data_Accuracy_Score' ,
							
								'$Rating_Result' ,
								'$Rating_Observations' ,
								'$Rating_Comments' ,
								'$Rating_Score' ,
								
								'$Underwriting_Result' ,
								'$Underwriting_Observations' ,
								'$Underwriting_Comments' ,
								'$Underwriting_Score',
								
								'$Information_Gathering_Result' ,
								'$Information_Gathering_Observations' ,
								'$Information_Gathering_Comments' ,
								'$Information_Gathering_Score',
						
								'$Underwriting_Authority_Result' ,
								'$Underwriting_Authority_Observations' ,
								'$Underwriting_Authority_Comments' ,
								'$Underwriting_Authority_Score',
								
								'$Process_Result' ,
								'$Process_Observations' ,
								'$Process_Comments' ,
								'$Process_Score' ,
							
								'$Service_Result',
								'$Service_Observations' ,
								'$Service_Score', 
						
								'$Overall_Score_Quantitative',
								'$Overall_Score_Qualitative',
							
								'$Date_Created', 
								'$Created_By', 
							
								'$Date_Modified',
								'$Modified_By', 
								
								'$Action_Required', 
								'$Action_Status', 
								'$Overall_Comments'
								)"; 
						}else if ($review_template_type=="IRT"){
							$q="INSERT intakereviewtable (
								Assigned_To,
								AT_TCH,
								Team_Leader,
								TL_TCH,						
								Reviewed_By,
								RB_TCH,
								Review_Type,
								Case_Number,
								Policy_Number,
								Region,
								Transaction_Type,
								Effective_Date,
								Line_of_Business,
								POLICY_NUMBER_RESULT, 							
								POLICY_EFFECTIVE_DATE_RESULT,					
								BROKER_CODE_RESULT,								
								NAMED_INSURED_RESULT,                           
								TRANSACTION_TYPE_RESULT,
								LINE_OF_BUSINESS_RESULT,
								RISK_TYPE_RESULT,
								AUTHORITY_LEVEL_RESULT,
								MARKET_RESERVATION_RESULT,
								IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT,
								SELECTED_THE_CORRECT_BROKER_CODE_RESULT,
								FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT,
								POLICY_NUMBER_COMMENTS,
								BROKER_CODE_COMMENTS,
								POLICY_EFFECTIVE_DATE_COMMENTS,
								NAMED_INSURED_COMMENTS,
								TRANSACTION_TYPE_COMMENTS,
								LINE_OF_BUSINESS_COMMENTS,
								RISK_TYPE_COMMENTS,
								AUTHORITY_LEVEL_COMMENTS,
								MARKET_RESERVATION_COMMENTS,
								IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS,
								SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS,
					            FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS,
								POLICY_NUMBER_SCORE,
								BROKER_CODE_SCORE,
								POLICY_EFFECTIVE_DATE_SCORE,
								NAMED_INSURED_SCORE,
								TRANSACTION_TYPE_SCORE,
								LINE_OF_BUSINESS_SCORE,
								RISK_TYPE_SCORE,
								AUTHORITY_LEVEL_SCORE,
						        MARKET_RESERVATION_SCORE,
								IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE,
								SELECTED_THE_CORRECT_BROKER_CODE_SCORE,
								FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE,
								OVERALL_SCORE_QUANTITATIVE, 					
								OVERALL_SCORE_QUALITATIVE,
								Action_Required, 
								Action_Status,
								OVERALL_COMMENTS,								
								DATE_CREATED,									
						        CREATED_BY, 									
								DATE_MODIFIED,									
								MODIFIED_BY) 
								VALUES (
								'$Assigned_To_hidden_name',
								'$AT_TCH',
								'$Team_Leader_hidden_name',
								'$TL_TCH',
								'$Reviewed_By_hidden_name',
								'$RB_TCH', 										
								'$Review_Type',
								'$Case_Number',
								'$Policy_Number',
								'$Region', 		                                
								'$Transaction_Type',
								'$Effective_Date',
								'$Line_of_Business',
								'$POLICY_NUMBER_RESULT', 							
								'$POLICY_EFFECTIVE_DATE_RESULT',					
								'$BROKER_CODE_RESULT',
								'$NAMED_INSURED_RESULT',
								'$TRANSACTION_TYPE_RESULT',
								'$LINE_OF_BUSINESS_RESULT',
								'$RISK_TYPE_RESULT',
								'$AUTHORITY_LEVEL_RESULT',
								'$MARKET_RESERVATION_RESULT',
								'$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_RESULT',
								'$SELECTED_THE_CORRECT_BROKER_CODE_RESULT',
								'$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_RESULT',
								'$POLICY_NUMBER_COMMENTS',
								'$BROKER_CODE_COMMENTS',
								'$POLICY_EFFECTIVE_DATE_COMMENTS',
								'$NAMED_INSURED_COMMENTS',
								'$TRANSACTION_TYPE_COMMENTS',
								'$LINE_OF_BUSINESS_COMMENTS',                      
								'$RISK_TYPE_COMMENTS',
								'$AUTHORITY_LEVEL_COMMENTS',
								'$MARKET_RESERVATION_COMMENTS',
								'$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_COMMENTS',
								'$SELECTED_THE_CORRECT_BROKER_CODE_COMMENTS',
								'$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_COMMENTS',
								'$POLICY_NUMBER_SCORE',
								'$BROKER_CODE_SCORE',
								'$POLICY_EFFECTIVE_DATE_SCORE',
								'$NAMED_INSURED_SCORE',
								'$TRANSACTION_TYPE_SCORE',
								'$LINE_OF_BUSINESS_SCORE',
								'$RISK_TYPE_SCORE',
								'$AUTHORITY_LEVEL_SCORE',
								'$MARKET_RESERVATION_SCORE',
								'$IDENTIFICATION_OF_EXPRESS_AND_MIDMARKET_SCORE',
								'$SELECTED_THE_CORRECT_BROKER_CODE_SCORE',
								'$FOLLOWED_EXCEPTION_PROCESS_WHERE_APPLICABLE_SCORE',
								'$OVERALL_SCORE_QUANTITATIVE',
								'$OVERALL_SCORE_QUALITATIVE',
								'$ACTION_REQUIRED',
								'$ACTION_STATUS',
								'$OVERALL_COMMENTS',
								'$DATE_CREATED',
								'$CREATED_BY',
								'$DATE_MODIFIED',
								'$MODIFIED_BY'
								)";	
								}
				}
								
				
				error_log($q);
				$r = mysqli_query($dbc, $q);
				if($r){
					if (isset($_POST['ID']) && is_numeric($_POST['ID'])){
						$message = '<p>QRT form was updated successfully</p>';
					    echo "<script type='text/javascript'>alert('QRT form was updated successfully!')</script>";	
					}else {
						$message = '<p>QRT form was added successfully</p>';	
						echo "<script type='text/javascript'>alert('QRT form was added successfully!')</script>";						
					}
					//header("Loaction:: index.php");
					echo $message;
				}
				else{
	
				$message= '<p> QRT form could not be added because: '.mysqli_error($dbc).'</p>';
				echo "<script type='text/javascript'>alert('QRT form could not be added successfully!')</script>";			
				//echo '<p>'.$q.'</p>';	
				echo $message;			
				}
				
			}
		    ?>
			
<!--Review Search Panel -->			
			<div class ="list-group">
			<h4 class="list-group-item-heading" >Please Select the Retrieval Criterial (Only returns the most recent 4 months' records.)</h4>
			
			<label>Review Template Type</label>
			<select class="form-control" name="search_review_template" id="search_review_template">
			<option value= "Null"> Please Select </option>
			
			<?php $review_template= array("TRT","IRT","CRT")?>
						
						
						<?php foreach ($review_template as $key => $value):	
						if (strtoupper($_GET['review_template'])==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
			</select>
						
			<label>Reviewee Name</label>
			<select class="form-control" name="search_reviewee" id="search_reviewee">
			<option value= "Null"> Please Select </option>
			<option value= "%"> All</option>
			<?php	
						
					
				    	$q = "SELECT * FROM userlistqrt";
						$r = mysqli_query($dbc,$q);
						
						
						
							while ($emoloyee_list = mysqli_fetch_assoc($r)){ 
							$employee_data=data_employee($dbc, $emoloyee_list['3CHID']);
							?>
							<option value ="<?php echo $employee_data['3CHID']?>"
							
							<?php if (isset($opened['AT_TCH'])|| $_POST['search_reviewee'] == $employee_data['3CHID']||$employee_data['3CHID']==$result['AT_TCH']){
							
									if($employee_data['3CHID']==$opened['AT_TCH']||$employee_data['3CHID'] == $_POST['search_reviewee']||$employee_data['3CHID']==$result['AT_TCH']){echo 'selected';}
								} 	
								?>><?php echo $employee_data['fullname'];?> </option>
						<?php } 
			?> 
			</select>			
			<label>Reviewer Name</label>
			<select class="form-control" name="search_reviewer" id="search_reviewer">
			<option value= "Null"> Please Select </option>
			<option value= "%"> All</option>
			<?php	
						
					
				    	$q = "SELECT * FROM userlistqrt WHERE Reviewer = 1";
						$r = mysqli_query($dbc,$q);
						while ($emoloyee_list = mysqli_fetch_assoc($r)){ 
							$employee_data=data_employee($dbc, $emoloyee_list['3CHID']);
							?>
							<option value ="<?php echo $employee_data['3CHID']?>"
							
							<?php if (isset($opened['RB_TCH'])|| $_POST['search_reviewer'] == $employee_data['3CHID']||$employee_data['3CHID']==$result['RB_TCH']){
							
									if($employee_data['3CHID']==$opened['RB_TCH']||$employee_data['3CHID'] == $_POST['search_reviewer']||$employee_data['3CHID']==$result['RB_TCH']){echo 'selected';}
								} 	
								?>><?php echo $employee_data['fullname'];?> </option>
						<?php } 
			?>  

		
			</select>

			
		
			
			<label>Transaction Type</label>
												
						<select class="form-control" name="Search_Transaction_Type" id="Search_Transaction_Type" >
						<option value= "Null"> Please Select </option>
						<option value= "%">All</option>
						<?php $trans_type= array("Abeyance","CAC Inquiry","Cancellation","Cert of Ins - Needed","Cert of Ins - Submitted","Claims Alert","Inquiry","Large Loss","Letter of Authority","Letter of Experience","New Business","Policy Change","Quote","Re-Instatement","Renewal")?>
						
						
						<?php foreach ($trans_type as $key => $value):	
						if ($opened['Transaction_Type']==$value||$_POST['Search_Transaction_Type']==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						</select>
						
			<label>Review Type</label>
												
						<select class="form-control" name="Search_Review_Type" id="Search_Review_Type" >
						<option value= "Null"> Please Select </option>
						<option value= "%">All</option>
						<?php $review_type= array("Monthly","Optional")?>
						
						
						<?php foreach ($review_type as $key => $value):	
						if ($opened['Review_Type']==$value ||$_POST['Search_Review_Type']==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						</select>
						
					
											
			<label>Action Required</label>
												
						<select class="form-control" name="Search_Action_Required" id="Search_Action_Required" >
						<option value= "Null"> Please Select </option>
						<option value= "%">All</option>
						<?php $action_required= array("Correction Required", "Correction Required at Renewal","Correction Required Mid-Term", "Correction Required Mid-Term: Immediate Action",
												"Flag File for Manual Review at Renewal","Immediate Follow-up and Action Required","N/A")?>
						
						<?php foreach ($action_required as $key => $value):	
						if ($opened['Action_Required']==$value ||$_POST['Search_Action_Required']==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						</select>
						
			<button type="submit" name="Read_From_Database" class="btn btn-default">Search From Database</button>
			<br>
			<?php 
		
						if (isset($_GET['trt_id'])||isset($_GET['irt_id'])||isset($_GET['crt_id'])){ // if the page is already existed and opened, then show only that record.
							if (isset($_GET['trt_id'])){ $page_id = $_GET['trt_id'];
								$q = "SELECT * FROM transactionalreviewtable WHERE ID = '$page_id'";
								} else if (isset($_GET['irt_id'])){
								$page_id = $_GET['irt_id'];
								$q = "SELECT * FROM intakereviewtable WHERE ID = '$page_id'";
								}else if (isset($_GET['crt_id'])){
								$page_id = $_GET['crt_id'];
								$q = "SELECT * FROM callreviewtable WHERE ID = '$page_id'";}
	
							
							$r5 = mysqli_query($dbc,$q);
							$result=mysqli_fetch_assoc($r5);
							$case_number = $result['Case_Number'];
							$select_name = $result['AT_TCH'];
							
							echo '<div class = "form-control" id="serach_result">';
							echo "<ul>";
							
							
								echo "<li><a href = 'index.php?id=".$page_id."'>". "$case_number"."</a></li>";
							
							echo "</ul>";
							echo "</div>";
						}else{
							$select_review_template = $_POST['search_review_template'];
							$select_id = $_POST['search_reviewee'];
							$select_reviewer = $_POST['search_reviewer'];
							$select_trans=$_POST['Search_Transaction_Type'];
							$select_review_type=$_POST['Search_Review_Type'];
							$select_action_required=$_POST['Search_Action_Required'];
							
							error_log( "search box select reviewee is: ".$select_id . "search box select review template is: ".$select_review_template);
						
							if($select_review_template == "TRT"){
								$q = "SELECT * FROM transactionalreviewtable WHERE AT_TCH LIKE '$select_id'AND Transaction_Type LIKE '$select_trans' 
								AND Review_Type LIKE '$select_review_type' AND Action_Required LIKE '$select_action_required'
								AND RB_TCH LIKE '$select_reviewer'							
								AND Date_Created BETWEEN CURDATE() - INTERVAL 120 DAY AND CURDATE()+INTERVAL 1 DAY  "; //GROUP BY Review_Month
								$r = mysqli_query($dbc, $q);
								error_log ($q);
								 error_log ("the number of rows returned is: ". mysqli_num_rows($r));
								 if (mysqli_num_rows($r) == 0){
								
									echo ("<h4>There is no matching record of your search criterial</h4>");
								 }
								 else{ 
									$current_rec = null;
									echo '<div id="serach_result">';
									echo "<ul>";
									foreach ($r as $current_rec){
										echo "<li><a href = 'index.php?review_template=TRT&trt_id=". $current_rec['ID']."'>". $current_rec['Case_Number']."</a></li>";
									}
								echo "</ul>";
								echo "</div>";
								}
							}else if ($select_review_template == "IRT"){
								$q = "SELECT * FROM intakereviewtable WHERE AT_TCH LIKE '$select_id'AND Transaction_Type LIKE '$select_trans' 
								AND Review_Type LIKE '$select_review_type' AND Action_Required LIKE '$select_action_required'
								AND RB_TCH LIKE '$select_reviewer'							
								AND Date_Created BETWEEN CURDATE() - INTERVAL 120 DAY AND CURDATE()+INTERVAL 1 DAY  "; //GROUP BY Review_Month
								$r = mysqli_query($dbc, $q);
								error_log ($q);
								 error_log ("the number of rows returned is: ". mysqli_num_rows($r));
								 if (mysqli_num_rows($r) == 0){
								
									echo ("<h4>There is no matching record of your search criterial</h4>");
								 }
								 else{ 
									$current_rec = null;
									
									echo '<div id="serach_result">';
									echo "<ul>";
									foreach ($r as $current_rec){
										error_log ("the intake review page id is: ". $current_rec['ID']);
										echo "<li><a href = 'index.php?review_template=IRT&irt_id=". $current_rec['ID']."'>". $current_rec['Case_Number']."</a></li>";
									}
								echo "</ul>";
								echo "</div>";
								}
							} else if ($select_review_template == "CRT"){
								$q = "SELECT * FROM callreviewtable WHERE AT_TCH LIKE '$select_id'AND Transaction_Type LIKE '$select_trans' 
								AND Review_Type LIKE '$select_review_type' AND Action_Required LIKE '$select_action_required'
								AND RB_TCH LIKE '$select_reviewer'							
								AND Date_Created BETWEEN CURDATE() - INTERVAL 120 DAY AND CURDATE()+INTERVAL 1 DAY  "; //GROUP BY Review_Month
								$r = mysqli_query($dbc, $q);
								error_log ($q);
								 error_log ("the number of rows returned is: ". mysqli_num_rows($r));
								 if (mysqli_num_rows($r) == 0){
								
									echo ("<h4>There is no matching record of your search criterial</h4>");
								 }
								 else{ 
									$current_rec = null;
									echo '<div id="serach_result">';
									echo "<ul>";
									foreach ($r as $current_rec){
										echo "<li><a href = 'index.php?review_template=CRT&crt_id=". $current_rec['ID']."'>". $current_rec['Case_Number']."</a></li>";
									}
								echo "</ul>";
								echo "</div>";
								}
							}
							
						}?>
				
				
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
		</form>
	</div>
	
	</div>	
	<?php //include(D_TEMPLATE.'/footer.php'); //Page Footer ?>
          	    
</body>
</html>