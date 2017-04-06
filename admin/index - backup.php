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
global $yellow;
$yellow = "#D3EA0E";

global $transaction_types;
$transaction_types= array("Renewal Prep","Renewal Issuance","Policy Change","New Business","Certificate of Insurance - Needed","Cancellation","Letter of Experience","Letter of Authority");
						
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
global $url_trantype;
global $url_prodtype;
if(isset($_GET['trans'])){
	$url_trantype=$_GET['trans'];
}
if (isset($_GET['product'])){
	$url_prodtype=$_GET['product'];
	error_log ("prodtype is ".$url_prodtype);
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
	<title>RPC Spot Check Form</title>
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

<h1><strong>RPC QRT Form</strong></h1>
	
<div class="row">
	
		
		
	<div class= "col-md-9">
			
			<?php
				
					$q = "SELECT * FROM transactionalreviewtable";
					$r = mysqli_query($dbc, $q);
					$opened = mysqli_fetch_assoc($r);
					$is_locked = $opened['is_locked'];
					//error_log("well" .  $opened['well_challenge']);
				
				
			?>
			<form id = "main_form" action="index.php" method="POST" role="form">
				
				<div class="section">
					<label class ="form-group" for="title">Page ID</label>
					<input  class="form-control" type="text" name="ID" id="ID"value="<?php echo $opened['ID'];?>" placeholder="" readonly> 
				
					<label class ="form-group" for="title">Review Template Type <span class="mandatory">***</span></label>
					<input  class="form-control" type="text" name="review_template" id="review_template" value=
					"<?php if($_GET['review_template']=='Auto'){echo 'Auto';} else if ($_GET['review_template']=='Property'){
						echo 'Property';
					}?>" placeholder="review template" readonly> 
				
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
					<label style="display:none;" class ="form-group" for="leader">Reviewee ID</label>
					<input  class="form-control" type="hidden" name="AT_TCH" id = "AT_TCH" value= "<?php echo $opened['AT_TCH'];?>" readonly>
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
					<label  style="display:none;" class ="form-group" for="leader">Leader ID</label>
					<input  type="hidden" class="form-control" type="text" name="TL_TCH" id = "TL_TCH" value="<?php echo $opened['TL_TCH']?>"  placeholder="Leader ID" readonly>
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
						$q= "SELECT * FROM userlistqrt WHERE TeamLeader = 1";
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
					<label  style="display:none;" class ="form-group" for="leader">Reviewer ID</label>
					<!--<h2  class ="form-group" for="leader">Reviewer ID</h2>-->
					<input  class="form-control" type="hidden" name="RB_TCH" id="RB_TCH" value= "<?php echo $opened['RB_TCH']//strtoupper($_SESSION[username]);?>" placeholder="" readonly>
					
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
							<label for="date">Date Reviewed</label>
								<div class="input-group date" id="datePicker" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
									<input  data-format="YYYY-MM-DD hh:mm"  class="form-control" type="text" id="Effective_Date" name="Effective_Date" <?php echo $is_locked ;?> />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
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
		
				</div>
				

				<br>
				
				<div class="section">
				<!--<h2 class="title" >Goal 1: Engagement</h2>	-->
					<div class="form-group">
						<label class="control-label" >Case Number<span class="mandatory">***</span></label>
						<input  class="form-control"  id="Case_Number" name="Case_Number" <?php echo $is_locked ;?> value="<?php echo $opened['Case_Number'];?>" >
						
						<label class="control-label">Policy Number </label>
						<input  class="form-control"  id="Policy_Number" name="Policy_Number" <?php echo $is_locked ;?> value= "<?php echo $opened['Policy_Number'];?>" >
					
						<label class="control-label">Transaction Type<span class="mandatory">*</span></label>
												
						<select class="form-control" name="Transaction_Type" id="Transaction_Type"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php $trans_type= $transaction_types?>
						
						
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
						
						<input  class="form-control"  id="trans" name="trans" <?php echo $is_locked ;?> >				
						
						<label class="control-label">Product Type</label>
												
						<select class="form-control" name="Product_Type" id="Product_Type"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php 
						$lob= array("Auto","Property");
								?>
						
						<?php foreach ($lob as $key => $value):	
							if ($opened['product_type']==$value){
								echo '<option value="'.$value.'" selected>'.$value.'</option>';
							}else{
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
							}
							endforeach;
						?>
						</select>
						
						<script>
						/*  $('#Transaction_Type').change(function(){
							//alert($(this).val());
							$('#review_template').val($(this).val());
						}) */
						</script>			
				
				<script>
				 $(document).ready(function(){ /* PREPARE THE SCRIPT */
					$("#Transaction_Type").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
					  var trans_type = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
					 
					  //alert(trans_type);
					 
					  $.ajax({ /* THEN THE AJAX CALL */
						type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
						url: "get-data.php", /* PAGE WHERE WE WILL PASS THE DATA */
						data: 'trans_type='+trans_type, /* THE DATA WE WILL BE PASSING */
						success: function(result){ /* GET THE TO BE RETURNED DATA */
						  //$("#show_page").html(result);
						  $("#trans").val=result;
							//alert(result);						  /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
						}
					  });

					});
				  });
				
							
			
			</script>	
						
						

						</script>
					
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
		
						 <div id="eventForm" class="section">
							<label for="date">Effective Date</label>
								<div class="input-group date" id="EffectiveDate" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
									<input  data-format="YYYY-MM-DD"  class="form-control" type="text" id="Effective_Date" name="Effective_Date" <?php echo $is_locked ;?> />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
						</div>
						  
						</div>
						
						 <script>
							$(document).ready(function() {
								$('#EffectiveDate').datepicker({
										//format:'yyyy-mm-dd'
										defaultDate: "<?php echo $opened['Effective_Date'];?>"
										//console.log($('#datePicker').datepicker('getDate'));
									});
											
						});
							
						</script>
						
						
				</div>
					
					
					
				<!-- Question section -->
				
				<!--<h2 class="title" >Goal 1: Engagement</h2>	-->
					
	<div class="form-group" id="qrt-form",name="qrt-form">
			<script>
						var green = "<?php echo $GLOBALS['green'];?>"
						var red = "<?php echo $GLOBALS['red'];?>"
						var white = "<?php echo $GLOBALS['white'];?>"
						var yellow = "<?php echo $GLOBALS['yellow'];?>"
			</script>
<?php 

if ($url_prodtype=="auto"&($url_trantype=="RenewalPrep"||$url_trantype=="RenewalIssuance")){
$risk_assessment = array("Were underwirter instructions acted on correctly?");
$authorities=array("Was the transaction within the user’s authority? If not, were appropriate approvals obtained?");
$sl_agree=array("When the processor took control of the case, was it handled in an appropriate amount of time?");
$data_entry_process=array("Were related cases with earlier effective dates escalated prior to renewal prep?",						"Were the necessary MVRS ordered or entered manually?",
						"Was the master drivers list updated correctly?",
						"Was the underwriter advised of any driver concerns?",
						"Was the premium and loss record completed correctly?",
						"Was the renewal WIP/renewal GarageRater prepped as per underwriter instruction?",
						"Were the 43/43A endorsements updated as per provincial standards?",
						"Was the CVOR/OMVIC registration status checked?",
						"Was the underwriter notified of any open abeyances?",
						"Were any cross reference policies noted appropriately?");
$sys_stat=array("Was appropriate full documentation added describing the transaction?");
}else if($url_prodtype=="auto"&$url_trantype=="PolicyChange"){
$risk_assessment = array("Were underwirter instructions acted on correctly?");
$authorities=array("Was the transaction within the user’s authority? If not, were appropriate approvals obtained?");
$sl_agree=array("When the processor took control of the case, was it handled in an appropriate amount of time?");
$data_entry_process=array("Were appropriate driver concerns referred to the underwriter?",
                                   "Were MVRS ordered or entered manually?",
                                   "Were any appropriate surcharges/adjustments added/removed correctly in PAS?",
                                   "Was the drivers list updated correctly?",
                                   "Was the broker notified appropriately?",
                                   "Were the appropriate referrals made to the underwriter?",
                                   "Was the data entered correctly into PAS (vehicle model, VIN, named insured, territory, rate group, 90named insured, address)?",
                                   "Were the appropriate endorsements added and premiums charged?",
                                   "Was the appropriate coverage added or removed?",
                                   "Were all interests shown appropriately on the policy?",
                                   "Were related cases processed in their respective order of effective dates?",
                                   "Was the WIP issued correctly? Was coding in ENTR completed correctly?",
                                   "Was the 25A/72 filled out correctly?",
                                   "Were all policy documents uploaded correctly to SharePoint (using proper naming conventions)?",
                                   "Were all appropriate endorsements and liability certificates sent to document delivery?",
                                   "Were any necessary registered letters sent to additional interests?",
                                   "Were prints ordered appropriately?",
                                   "Was the case sent to document delivery using the correct document generation status?"
                                   );
$sys_stat=array("Was appropriate full documentation added describing the transaction?");
}else if($url_prodtype=="auto"&$url_trantype=="NewBusiness"){
$risk_assessment = array("Were underwirter instructions acted on correctly?");
$authorities=array("Was the transaction within the user’s authority? If not, were appropriate approvals obtained?");
$sl_agree=array("When the processor took control of the case, was it handled in an appropriate amount of time?");
$data_entry_process=array("Were appropriate driver concerns referred to the underwriter?",
                                   "Were MVRS ordered or entered manually?",
                                   "Were any appropriate surcharges/adjustments added/removed correctly in PAS?",
                                   "Was the drivers list updated correctly?",
                                   "Was the broker notified appropriately?",
                                   "Were the appropriate referrals made to the underwriter?",
                                   "Was the data entered correctly into PAS (vehicle model, VIN, named insured, territory, rate group, named insured, address)?",
                                   "Were the appropriate endorsements added and premiums charged?",
                                   "Was the appropriate coverage added or removed?",
                                   "Were all interests shown appropriately on the policy?",
                                   "Were related cases processed in their respective order of effective dates?",
                                   "Was the WIP issued correctly? Was coding in ENTR completed correctly?",
                                   "Was the 25A/72 filled out correctly?",
                                   "Were all policy documents uploaded correctly to SharePoint (using proper naming conventions)?",
                                   "Were all appropriate endorsements and liability certificates sent to document delivery?",
                                   "Were any necessary registered letters sent to additional interests?",
                                   "Were prints ordered appropriately?",
                                   "Was the case sent to document delivery using the correct document generation status?"
                                   );
$sys_stat=array("Was appropriate full documentation added describing the transaction?");
}
	

?>				
	




	
						<div class="section">
				
						<label class="control-label" >Risk Assessment</label>
						<br>
						<?php for ($i=0;$i<sizeof($risk_assessment);$i++){?>
							<label class="control-label" ><?php echo $risk_assessment[$i];?></label>
							<br>
							<?php
							$var_result = "risk_assessment_result"."_".$i;
							if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
							if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
							if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
							if ($opened[$var_result]=='Null'){$r3="selected";$bc="yellow";}else{$r3="";};
							$var_obs = "risk_observation_".$i;					
							?>
							
							<label class="control-label">Result<span class="mandatory">***</span></label>
							<select class="reslut_selection" name="risk_assessment_result_<?php echo $i; ?>" id="risk_assessment_result_<?php echo $i; ?>" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  onchange="color_change(this)">
								<option value= "Null" > Please Select</option>
								<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
								<option class="red" value= "No" <?php echo $r2?>>No</option>
								<option class="white" value= "N/A" <?php echo $r3?>>N/A</option>
							</select>
							
													
							<input  type="hidden" class="form-control" type="text" name="risk_assessment_score_<?php echo $i;?>" id = "risk_assessment_score_<?php echo $i;?>" value="<?php echo $opened['risk_assessment_score_'.$i];?>"  placeholder="Risk_Assessment_Score" readonly >
							
							<label class="control-label">Observation</label>
							
							<select class="form-control" name="risk_assessment_observation_<?php echo $i;?>" id="risk_assessment_observation_<?php echo $i;?>"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
							
							<option value= "Null > Please Select</option>
							<?php $risk_observation_type= array("Please Select") ?>
								
							<?php
							foreach ($risk_observation_type as $key => $value){
								
								if($opened[var_obs]==$value){
									echo '<option value="'.$value.'" selected>'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
								}
							}
							?> 
							</select>
			
							<label class="control-label">Comments</label>
							<textarea type="text"  class="form-control" rows="2" id="Risk_Assessment_Comments" name="Risk_Assessment_Comments" <?php echo $is_locked ;?> ><?php echo $opened['Risk_Assessment_Comments'];?></textarea>						
							
						</div>
						<br>
						
				<?php } ?>
						
						<script>
							
						var green = "<?php echo $GLOBALS['green'];?>";
						var red = "<?php echo $GLOBALS['red'];?>";
						var white = "<?php echo $GLOBALS['white'];?>";
						//var ids=["risk_assessment_result_0","authorities_result_0"];
						
												
					function color_change(obj){
						var id = obj.id;
						var value = obj.value;
						runBackgroundChange();	
					function runBackgroundChange(){
						elementId = id;
			
						if (value != "Null") {
							
							if(value=="Yes")
								document.getElementById(elementId).style.backgroundColor=green;
							if(value=="No")
								document.getElementById(elementId).style.backgroundColor=red;
							if(value=="N/A")
								document.getElementById(elementId).style.backgroundColor=white;
						} else {
							document.getElementById(elementId).style.backgroundColor="yellow";
						};
						
					}
											
									
					}		 
					
						</script>
						
					<!--Focus #2: Authorities-->
					<div class="section">
						
						<label class="control-label" >Authorities</label>
						<br>
						<?php for ($i=0;$i<sizeof($authorities);$i++){?>
							<label class="control-label" ><?php echo $authorities[$i];?></label>
							<br>
							<?php
							$var_result = "authorities_result"."_".$i;
							if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
							if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
							if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
							if ($opened[$var_result]=='Null'){$r3="selected";$bc="yellow";}else{$r3="";};
							$var_obs = "authorities_observation_".$i;	
							$var_comments = "authorites_comments_".$i;
							?>
							
							<label class="control-label">Result<span class="mandatory">***</span></label>
							<select class="reslut_selection" name="authorities_result_<?php echo $i; ?>" id="authorities_result_<?php echo $i; ?>" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> onchange="color_change(this)">
							<option value= "Null" > Please Select</option>
							<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
							<option class="red" value= "No" <?php echo $r2?>>No</option>
							<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
							</select>
							
													
							<input  type="hidden" class="form-control" type="text" name="authorities_score_<?php echo $i;?>" id = "authorities_score_<?php echo $i;?>" value="<?php echo $opened['authorities_score_'.$i];?>"  placeholder="authorities_score" readonly >
							
							<label class="control-label">Observation</label>
							
							<select class="form-control" name="<?php echo $var_obs;?>" id=<?php echo $var_obs;?>  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
							
							<option value= "Null > Please Select</option>
							<?php $authorities_observation_type= array("Please Select") ?>
								
							<?php
							foreach ($authorities_observation_type as $key => $value){
								
								if($opened[var_obs]==$value){
									echo '<option value="'.$value.'" selected>'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
								}
							}
							?> 
							</select>
			
							<label class="control-label">Comments</label>
							<textarea type="text"  class="form-control" rows="2" id=<?php echo $var_comments; ?> name=<?php echo $var_comments; ?> <?php echo $is_locked ;?> ><?php echo $opened[$var_comments];?></textarea>	
						<?php }?>	
					</div>
					<br>
					
					<!--Focus #3: Service Level agreement-->
					<div class="section">
						
						<label class="control-label" >Service Level Agreements</label>
						<br>
						<?php for ($i=0;$i<sizeof($sl_agree);$i++){?>
							<label class="control-label" ><?php echo $sl_agree[$i];?></label>
							<br>
							<?php
							$var_result = "sl_agree_result"."_".$i;
							$var_obs = "sl_agree_observation_".$i;	
							$var_score = "sl_agree_score".$i;
							$var_comments = "sl_agree_comments_".$i;
							
							
							if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
							if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
							if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
							
							?>
							
							<label class="control-label">Result<span class="mandatory">***</span></label>
							<select class="reslut_selection" name=<?php echo $var_result; ?> id=<?php echo $var_result; ?> style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> onchange="color_change(this)">
							<option value= "Null" > Please Select</option>
							<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
							<option class="red" value= "No" <?php echo $r2?>>No</option>
							<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
							</select>
							
													
							<input  type="hidden" class="form-control" type="text" name=<?php echo $var_score;?> id =<?php echo $var_score;?> value="<?php echo $opened[$var_score];?>"  placeholder="" readonly >
							
							<label class="control-label">Observation</label>
							
							<select class="form-control" name="<?php echo $var_obs;?>" id=<?php echo $var_obs;?>  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
							
							<option value= "Null >Please Select</option>
							<?php $sl_agree_observation_type= array("Please Select") ?>
								
							<?php
							foreach ($sl_agree_observation_type as $key => $value){
								
								if($opened[var_obs]==$value){
									echo '<option value="'.$value.'" selected>'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
								}
							}
							?> 
							</select>
			
							<label class="control-label">Comments</label>
							<textarea type="text"  class="form-control" rows="2" id=<?php echo $var_comments; ?> name=<?php echo $var_comments; ?> <?php echo $is_locked ;?> ><?php echo $opened[$var_comments];?></textarea>	
						<?php }?>	
					</div>
					<br>
					
					
					<!--Focus #4: Data entry and processes-->
					<div class="section">
						
						<label class="control-label" >Data Entry & Processes</label>
						<br>
						<?php for ($i=0;$i<sizeof($data_entry_process);$i++){?>
							<label class="control-label" ><?php echo $data_entry_process[$i];?></label>
							<br>
							<?php
							$var_result = "data_entry_process_result"."_".$i;
							$var_obs = "data_entry_process_observation_".$i;	
							$var_score = "data_entry_process_score".$i;
							$var_comments = "data_entry_process_comments_".$i;
							
							
							if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
							if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
							if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
							
							?>
							
							<label class="control-label">Result<span class="mandatory">***</span></label>
							<select class="reslut_selection" name=<?php echo $var_result; ?> id=<?php echo $var_result; ?> style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>onchange="color_change(this)" >
							<option value= "Null" > Please Select</option>
							<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
							<option class="red" value= "No" <?php echo $r2?>>No</option>
							<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
							</select>
							
													
							<input  type="hidden" class="form-control" type="text" name=<?php echo $var_score;?> id =<?php echo $var_score;?> value="<?php echo $opened[$var_score];?>"  placeholder="" readonly >
							
							<label class="control-label">Observation</label>
							
							<select class="form-control" name="<?php echo $var_obs;?>" id=<?php echo $var_obs;?>  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
							
							<option value= "Null >Please Select</option>
							<?php $data_entry_process_observation_type= array("Please Select") ?>
								
							<?php
							foreach ($data_entry_process_observation_type as $key => $value){
								
								if($opened[var_obs]==$value){
									echo '<option value="'.$value.'" selected>'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
								}
							}
							?> 
							</select>
			
							<label class="control-label">Comments</label>
							<textarea type="text"  class="form-control" rows="2" id=<?php echo $var_comments; ?> name=<?php echo $var_comments; ?> <?php echo $is_locked ;?> ><?php echo $opened[$var_comments];?></textarea>	
						<?php }?>	
							
					</div>
				
					<br>
					
					<!--Focus #5: SYSTEM & STATISTICAL-->
					<div class="section">
						
						<label class="control-label" >SYSTEM & STATISTICAL</label>
						<br>
						<?php for ($i=0;$i<sizeof($sys_stat);$i++){?>
							<label class="control-label" ><?php echo $sys_stat[$i];?></label>
							<br>
							<?php
							$var_result = "sys_stat_result"."_".$i;
							$var_obs = "sys_stat_observation_".$i;	
							$var_score = "sys_stat_score".$i;
							$var_comments = "sys_stat_comments_".$i;
							
							
							if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
							if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
							if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
							
							?>
							
							<label class="control-label">Result<span class="mandatory">***</span></label>
							<select class="reslut_selection" name=<?php echo $var_result; ?> id=<?php echo $var_result; ?> style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>onchange="color_change(this)" >
							<option value= "Null" > Please Select</option>
							<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
							<option class="red" value= "No" <?php echo $r2?>>No</option>
							<option class="" value= "N/A" <?php echo $r3?>>N/A</option>
							</select>
							
													
							<input  type="hidden" class="form-control" type="text" name=<?php echo $var_score;?> id =<?php echo $var_score;?> value="<?php echo $opened[$var_score];?>"  placeholder="" readonly >
							
							<label class="control-label">Observation</label>
							
							<select class="form-control" name="<?php echo $var_obs;?>" id=<?php echo $var_obs;?>  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?> >
							
							<option value= "Null >Please Select</option>
							<?php $sys_stat_observation_type= array("Please Select") ?>
								
							<?php
							foreach ($sys_stat_observation_type as $key => $value){
								
								if($opened[var_obs]==$value){
									echo '<option value="'.$value.'" selected>'.$value.'</option>';
								}else{
									echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
								}
							}
							?> 
							</select>
			
							<label class="control-label">Comments</label>
							<textarea type="text"  class="form-control" rows="2" id=<?php echo $var_comments; ?> name=<?php echo $var_comments; ?> <?php echo $is_locked ;?> ><?php echo $opened[$var_comments];?></textarea>	
						<?php }?>	
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
				
			<button class ="list-group-item" id="add_auto" name="add_auto" style="background-color:#E6E6FA;">
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Auto Review</h4>
				<?php for ($i=0;$i<sizeof($transaction_types);$i++){?>
				<?php $href="index.php?product=auto"."&trans=".str_replace(" ","",$transaction_types[$i])?>
				<ul>
					   <li><a href = <?php echo $href;?>><?php echo $transaction_types[$i]?></a></li>
					 
				 </ul>
				<?php }?>
			   
			</button>
			<a class ="list-group-item" id="add_property" name="add_property"   href = "index.php?review_template=property" style="background-color:#E6E6FA">			
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Property Review</h4>
			</a>
			
			</div>
			<script>
			
			
			$(document).ready(function(){
				$("#add_auto").click(function(){
					$("ul").slideToggle();
				});
				
			});

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
				foreach($_POST as $key => $value) {
					error_log ("POST parameter '$key' has '$value'");
				}
				
				$q1="INSERT INTO transactiontable Set";
				IF ($KEY == "section name"){
					
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