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
global $product_types;
$product_types = array("Auto","Property");

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
 

/* if(isset($_GET['review_template'])||isset($_POST['review_template'])){
	if(isset($_GET['review_template'])){
		$review_template_type = $_GET['review_template'];
	error_log ("review template type got from url review template is: ".$review_template_type);
	}
	if(isset($_POST['review_template'])){
		$review_template_type = $_POST['review_template'];
		error_log ("review template type got from search panel is: ".$review_template_type);
	} 
	
	
} */
global $url_trantype;
global $url_prodtype;
if(isset($_GET['trans'])){
	$url_trantype=$_GET['trans'];
}
if (isset($_GET['product'])){
	$url_prodtype=$_GET['product'];
	error_log ("prodtype is ".$url_prodtype);
}
global $review_template;
$review_template = $url_prodtype."-".$url_trantype;
			
global $form_id;
if(isset($_GET['form_id'])){
	$form_id=$_GET['form_id'];
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
				if (isset($_GET['form_id'])){
					$q = "SELECT * FROM review WHERE form_id=$form_id";
					$r = mysqli_query($dbc, $q);
					$opened = mysqli_fetch_assoc($r);
					$is_locked = $opened['is_locked'];
					error_log("effective_date is " .  $opened['effective_date']);
				}
				
			?>
			<form id = "main_form" action="index.php" method="POST" role="form">
				
				<div class="section">
					<label class ="form-group" for="title">Page ID</label>
					<input  class="form-control" type="text" name="ID" id="ID"value="<?php echo $opened['ID'];?>" placeholder="" readonly> 
					<label class ="form-group" for="title">Form ID</label>
					<input  class="form-control" type="text" name="form_id" id="form_id"value="<?php echo $opened['form_id'];?>" placeholder="" readonly> 
				
					<label class ="form-group" for="title">Review Template Type <span class="mandatory">***</span></label>
					<input  class="form-control" type="" name="review_template" id="review_template" value=
					"<?php echo $review_template?>" placeholder="review template" readonly> 
				
				<div class="section">
				<label  class ="form-group" for="reviewee_name">Reviewee Name <span class="mandatory">***</span></label>
				<!--h2 class ="form-group" for="title">Leader Name</h2> -->
				<select class="form-control" name="reviewee_name" id="reviewee_name" >
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
				<?php if (isset($opened['reviewee_name'])){
									
									if($employee_list['3CHID']==$opened['reviewee_name']){echo 'selected';}
								} 	
								?>>
				<?php echo $employee_list['AgentName']?> </option>
				<?php }?>				
				</select>
				
				<label style="display:none;" class ="form-group" for="leader">Reviewee ID</label>
				<input  class="form-control" type="hidden" name="reviewee_id" id = "reviewee_id" value= "<?php echo $opened['reviewee_id'];?>" readonly>
				<script>
					 $('#reviewee_name').change(function(){
						//alert($(this).val());
						$('#reviewee_id').val($(this).val());
					});  

				</script>
				
				</div>
				
				<div class="section">
				<label  class ="form-group" for="leader">Leader Name <span class="mandatory">***</span></label>
				<!--h2 class ="form-group" for="title">Leader Name</h2> -->
				<select class="form-control" name="leader_name" id="leader_name" >
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
				<?php if (isset($opened['leader_name'])){
									
									if($employee_list['3CHID']==$opened['leader_name']){echo 'selected';}
								} 	
								?>>
				<?php echo $employee_list['AgentName']?> </option>
				<?php }?>				
				</select>
				
				<input class="form-control" type="hidden" name="Team_Leader_hidden_name" id = "Team_Leader_hidden_name" value = "">
					<label  style="display:none;" class ="form-group" for="leader">Leader ID</label>
					<input  type="hidden" class="form-control" type="text" name="leader_id" id = "leader_id" value="<?php echo $opened['leader_id']?>"  placeholder="Leader ID" readonly>
					<script>
						 $('#leader_name').change(function(){
							//alert($(this).val());
							$('#leader_id').val($(this).val());
						});  

					</script>
				
				</div>
				<br>
				<div class="section">
					
				
					<label  class ="form-group" for="reviewer">Reviewer Name (only list team leaders name)<span class="mandatory">***</span></label>
					<!--<h2  class ="form-group" for="leader">Reviewer Name</h2>-->
					<select class="form-control" name="reviewer_name" id="reviewer_name" >
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
					<?php if (isset($opened['reviewer_name'])){
										
										if($employee_list['3CHID']==$opened['reviewer_name']){echo 'selected';}
									} 	
									?>>
					<?php echo $employee_list['AgentName']?> </option>
					<?php }?>				
					</select>
					
					<input class="form-control" type="hidden" name="Reviewed_By_hidden_name" id = "Reviewed_By_hidden_name" value = "">	
					<label  style="display:none;" class ="form-group" for="leader">Reviewer ID</label>
					<!--<h2  class ="form-group" for="leader">Reviewer ID</h2>-->
					<input  class="form-control" type="hidden" name="reviewer_id" id="reviewer_id" value= "<?php echo $opened['reviewer_id']//strtoupper($_SESSION[username]);?>" placeholder="" readonly>
					
					<script>
						 $('#reviewer_name').change(function(){
							//alert($(this).val());
							$('#reviewer_id').val($(this).val());
						});  

					</script>
					
				</div>
				<br>
				<div class="section">
				
				
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
									<input  data-format="YYYY-MM-DD hh:mm"  class="form-control" type="text" id="date_reviewed" name="date_reviewed" <?php echo $is_locked ;?> />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
					</div>
						  
						
						
					<script>
							$(document).ready(function() {
								$('#datePicker').datetimepicker({
										//format:'yyyy-mm-dd'
										defaultDate: "<?php echo $opened['date_reviewed'];?>"
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
						<input  class="form-control"  id="case_number" name="case_number" <?php echo $is_locked ;?> value="<?php echo $opened['case_number'];?>" >
						
						<label class="control-label">Policy Number </label>
						<input  class="form-control"  id="policy_number" name="policy_number" <?php echo $is_locked ;?> value= "<?php echo $opened['policy_number'];?>" >
					
						<label class="control-label">Transaction Type</label>
						<input  class="form-control" type="text" name="transaction_type" id="transaction_type"value="<?php if ($opened['transaction_type']="Null") {echo $_GET['trans'];} else {echo $opened['transaction_type'];}?>" placeholder="" readonly> 
					<!-- transaction type is not modifiable -->	
					<?php /* ?>
						<select class="form-control" name="transaction_type" id="transaction_type"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>> Please Select</option>
						<?php $trans_type= $transaction_types?>
						
						
						<?php foreach ($trans_type as $key => $value):	
						if ($opened['transaction_type']==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
						</select>
						<?php // */ ?>
								
						
						<label class="control-label">Product Type</label>
						<input  class="form-control" type="text" name="product_type" id="product_type"value="<?php if ($opened['product_type']="Null") {echo $_GET['product'];} else {echo $opened['product_type'];}?>" placeholder="" readonly> 
						<?php /* 
						<select class="form-control" name="product_type" id="product_type"  <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
						<option value= "Null" <?php echo $r1?>>Please Select</option>
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
						<?php */?>
						
						<script>
						/*  $('#Transaction_Type').change(function(){
							//alert($(this).val());
							$('#review_template').val($(this).val());
						}) */
						</script>			
				
				<script>
				// may not need this script code
				 $(document).ready(function(){ /* PREPARE THE SCRIPT */
					$("#transaction_type").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
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
				<label class="control-label">Region</label>
												
				<select class="form-control" name="region" id="region" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
				<option value= "Null" >Please Select</option>
				<?php $region= array("Ontario","Atlantic","West","Quebec");?>
				<?php foreach ($region as $key => $value):	
				if($opened['region']==$value){
					echo '<option value="'.$value.'" selected>'.$value.'</option>'; //close your tags!!
				}else{
					echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
				}
				endforeach;
				?>
				</select>
				
				<label class="control-label">Authority Level</label>
												
				<select class="form-control" name="authority_level" id="authority_level" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
				<option value= "Null" >Please Select</option>
				<?php $authority_level= array("Underwriting Assistant","Underwriting Technician");?>
				<?php foreach ($authority_level as $key => $value):	
				if($opened['authority_level']==$value){
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
						<div class="input-group date" id="effective_date" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>>
							<input  data-format="YYYY-MM-DD"  class="form-control" type="text" id="effective_date" name="effective_date" <?php echo $is_locked ;?> />
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
				</div>
				  
				</div>
				
				 <script>
					$(document).ready(function() {
						$('#effective_date').datepicker({
								//format:'yyyy-mm-dd'
								defaultDate: "<?php echo $opened['effective_date'];?>"
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

//if ($url_prodtype=="auto"&$url_trantype=="RenewalPrep"){
	$q= "SELECT * FROM question WHERE product_type = '$url_prodtype' AND transaction_type= '$url_trantype' GROUP BY section ORDER BY 'ID'";

	error_log($q);
	$r = mysqli_query($dbc,$q);
					
	foreach ($r as $current_section){
	//$question_id=$current_section['ID'];;?>
	
	<div class="section">
	<label class="control-label" ><?php echo strtoupper($current_section[section])?></label>
	<br>
	<?php  
	$q1="SELECT * FROM question WHERE product_type = '$url_prodtype' AND transaction_type='$url_trantype' AND section='$current_section[section]' ";
	error_log($q1);
	$r1 = mysqli_query($dbc,$q1);
	$row = mysqli_fetch_array($r1);
	
	
	/* for ($i=0;$i<sizeof($row);$i++){
		$current_question=$row[$i];
		error_log("current question is ".$current_question);
	} */
	$i=0;
	foreach ($r1 as $current_question){
		$question_id=$current_question['ID'];;
	//error_log ($current_question['question_name'])?>
	
	<label class="control-label" ><?php echo $current_question['question_name'];?></label>
	<br>
	<label>Question ID <?php echo $question_id;?></label>
	<input  type="" class="form-control" type="text" name="<?php echo $question_id;?>" id = "<?php echo $question_id;?>" value="<?php echo $opened['question_id'];?>"  placeholder="question id" readonly >
	
	<?php
		$var_result = "questionid_".$question_id."_result";
		if ($opened[$var_result]=='Yes'){$r1="selected";$bc=$green;}else{$r1="";};
		if ($opened[$var_result]=='No') {$r2="selected";$bc=$red;}else{$r2="";};
		if ($opened[$var_result]=='N/A'){$r3="selected";$bc=$white;}else{$r3="";};
		if ($opened[$var_result]=='Null'){$r3="selected";$bc="yellow";}else{$r3="";};
		//$var_score = strtolower($current_section[section]).'_score'."_".$i;		
		$var_score = "questionid_".$question_id."_score";	
		$var_obs = "questionid_".$question_id."_observation";	
		$var_comment = "questionid_".$question_id."_comment";				
		?>	
	<label class="control-label">Result<span class="mandatory">***</span></label>
	<select class="reslut_selection" name="<?php echo $var_result?>" id="<?php echo $var_result?>" style="background:<?php echo $bc?>;" <?php if ($is_locked=="readonly"){echo "disabled='disabled'";}?>  onchange="color_change(this)">
		<option value= "Null" > Please Select</option>
		<option class="green" value= "Yes" <?php echo $r1?>>Yes</option>
		<option class="red" value= "No" <?php echo $r2?>>No</option>
		<option class="white" value= "N/A" <?php echo $r3?>>N/A</option>
	</select>
	<input  type="hidden" class="form-control" type="text" name="<?php echo $var_score?>" id = "<?php echo $var_score?>" value="<?php echo $opened['risk_assessment_score_'.$i];?>"  placeholder="Risk_Assessment_Score" readonly >
							
	<label class="control-label">Comments</label>
	<textarea type="text"  class="form-control" rows="2" id="<?php echo $var_comment?>" name="<?php echo $var_comment?>"  <?php echo $is_locked ;?> ><?php echo $opened['Risk_Assessment_Comments'];?>
	</textarea>	

 
	<?php $i=$i+1; error_log ("the number of question is: ".$i);?>		
	<?php }?>
	</div>	
	<br>
	
					
<?php }
//}
?>				
	
						
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
						

				<label class="control-label"> Overall Comments </label>
				<textarea type="text"  class="form-control" rows="4" id="overall_comments" name="overall_comments" <?php echo $is_locked ;?> ><?php echo $opened['overall_comments'];?></textarea>						
										
				<input type="hidden"  class="form-control"id="date_created" name="date_created" <?php echo $is_locked ;?> value = "<?php echo $opened['date_created'];?>" placeholder="Date Created">						
								
				<input type="hidden"  class="form-control"id="date_modified" name="date_modified" <?php echo $is_locked ;?> value = "<?php echo $opened['date_modified'];?>" placeholder="Date Modified">						
										
				<input type="hidden"  class="form-control" id="created_by" name="created_by" <?php echo $is_locked ;?>  value = "<?php echo $opened['created_by'];?>" placeholder="created_by">						

				<input type="hidden"  class="form-control"id="modified_by" name="modified_by" <?php echo $is_locked ;?> value = "<?php echo $opened['modified_by'];?>" placeholder="modified_by">						

				
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
	
<?php
				function get_string_between($string, $start, $end){
					$string = ' ' . $string;
					$ini = strpos($string, $start);
					if ($ini == 0) return '';
					$ini += strlen($start);
					$len = strpos($string, $end, $ini) - $ini;
					return substr($string, $ini, $len);
				}
				
				if(isset($_POST['submitted'])==1){
				
				error_log("is submit");


				$reviewee_name= mysqli_real_escape_string($dbc, $_POST['reviewee_name']);
				$reviewee_id= mysqli_real_escape_string($dbc, $_POST['reviewee_id']);
				$leader_name= mysqli_real_escape_string($dbc, $_POST['leader_name']);
				$leader_id= mysqli_real_escape_string($dbc, $_POST['leader_id']);
				$reviewer_name= mysqli_real_escape_string($dbc, $_POST['reviewer_name']);
				$reviewer_id= mysqli_real_escape_string($dbc, $_POST['reviewer_id']);
				
				$date_reviewed= mysqli_real_escape_string($dbc, $_POST['date_reviewed']);
				
				
				$case_number= mysqli_real_escape_string($dbc, $_POST['case_number']);
				$policy_number= mysqli_real_escape_string($dbc, $_POST['policy_number']);
				$transaction_type = mysqli_real_escape_string($dbc, $_POST['transaction_type']);
				$product_type= mysqli_real_escape_string($dbc, $_POST['product_type']);
				$region= mysqli_real_escape_string($dbc, $_POST['region']);
				$authority_level=mysqli_real_escape_string($dbc,$_POST['authority_level']);
				$effective_date= mysqli_real_escape_string($dbc, $_POST['effective_date']);
				$date_created= time();
				error_log("date_created".$date_created);
				$form_id =$date_created;
				
				$question_id_array = array();
				$result_array = array();
				foreach($_POST as $key => $value) {
					error_log ("POST parameter '$key' has '$value'");
					
					if(substr($key,0,10)=="questionid"){
						$id=get_string_between($key,'_','_');
						error_log("question id is ".$id);
						$question_temp = array();
						$question_temp['id'] = $id;
						$question_temp['value'] = $value;
						$question_id_array[]=$question_temp;
						
						$result_temp = array();
						$result_temp['id'] = $id;
						$result_temp['value'] = $value;
						$result_array[]=$result_temp;
						
											
						
						//$question_id_array[$id]="$id";
					//error_log("print question_id_array: ". print_r($question_id_array, TRUE));
					//error_log("print result_array: ". print_r($result_array, TRUE));
					}
				}
				error_log("print question_id_array: ". print_r($question_id_array, TRUE));
				error_log("print result_array: ". print_r($result_array, TRUE));
				
				
			
								
				if (!isset($_POST['form_id'])){
					$q = "UPDATE review SET 
					leader_id='$leader', 
					emp_id='$employee', 
					is_locked='$is_locked',
					date='$date', 
					title='$title',
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
					well='$well', 
					not_well='$not_well', 
					next_employee='$next_employee',
					next_leader='$next_leader' WHERE id= $_POST[page_id]";
				}else {
					//error_log("submit else loop, insert new");
					 for ($m=0;$m<sizeof($question_id_array);$m=$m+3){
						 error_log("m value is".$m);
						 $question_id=$result_array[$m]['id'];
						 $q1="SELECT question_name, section FROM question WHERE ID='$question_id'";
						 $r1 = mysqli_query($dbc, $q1);
						 $tt = mysqli_fetch_array($r1);
						 $question_name=$tt[0];
						 $section=$tt[1];
						// error_log ("tt value is ". $tt[0].$tt[1]);
							/* for ($i=0;$i<sizeof($row);$i++){
							$current_question=$row[$i];
							error_log("current question is ".$current_question);
						} */
						 $question_result=$result_array[$m]['value'];
						 $question_comment=$result_array[$m+2]['value'];
						$q = "INSERT review 
					  (form_id,
						reviewee_name,
						reviewee_id,
						leader_name,
						leader_id,
						reviewer_name,
						reviewer_id,
						date_reviewed,
						case_number,
						policy_number,
						transaction_type,
						product_type,
						region,
						authority_level,
						effective_date,
						section,
						question_id,
						question_name,
						result,
						comment,
						date_created) 
				VALUES ('$form_id',
						'$reviewee_name',
						'$reviewee_id',
						'$leader_name',
						'$leader_id',
						'$reviewer_name',
						'$reviewer_id',
						'$date_reviewed',
						'$case_number',
						'$policy_number',
						'$transaction_type',
						'$product_type',
						'$region',
						'$authority_level',
						'$effective_date',
						'$section',
						'$question_id',
						'$question_name',
						'$question_result',
						'$question_comment',
						'$date_created')"; 
						error_log($q);
						$r = mysqli_query($dbc, $q);
					 }
						
				}
				
				
				
				//error_log($q);
				//$r = mysqli_query($dbc, $q);
				if($r){
					if (isset($_POST['form_id']) && is_numeric($_POST['form_id'])){
						$message = '<p>spot check sheet was updated successfully</p>';
						echo "<script type='text/javascript'>alert('spot check was updated successfully')</script>";
					}else {
						$message = '<p>spot check was added successfully</p>';
					echo "<script type='text/javascript'>alert('spot check was added successfully')</script>";						
					}
					//header("Loaction:: index.php");
				
					echo $message;
				}
				else{
	
				$message= '<p> spot check sheet could not be added because: '.mysqli_error($dbc).'</p>';
				//echo '<p>'.$q.'</p>';	
				echo $message;			
				}
				
			}
		    ?>

		
		
	<div class= "col-md-3" id="sidebar">
		<form name = "seach_panel" action="index.php"  method = "POST">
			<div class ="list-group">
				
			<button class ="list-group-item" id="add_auto" name="add_auto" style="background-color:#E6E6FA;">
				<h4 class="list-group-item-heading" ><i class="fa fa-plus"></i>New Auto Review</h4>
				<?php for ($i=0;$i<sizeof($transaction_types);$i++){?>
				<?php $href="index.php?product=Auto"."&trans=".urlencode($transaction_types[$i])?>
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
			
			
			
<!--Review Search Panel -->			
			<div class ="list-group">
			<h4 class="list-group-item-heading" >Please Select the Retrieval Criterial (Only returns the most recent 4 months' records.)</h4>
			
			<label>Product Type</label>
			<select class="form-control" name="search_product_type" id="search_product_type">
			<option value= "Null"> Please Select </option>
			<option value= "%"> All</option>
			<?php $search_product_type= $product_types?>
						
						
						<?php foreach ($search_product_type as $key => $value):	
						if ($url_prodtype==$value){
							//echo '<option value="'.($key+1).'" selected>'.$value.'</option>';
							echo '<option value="'.$value.'" selected>'.$value.'</option>';
						}else{
							echo '<option value="'.$value.'">'.$value.'</option>';
						}					
						endforeach;
													
						?>
						
			</select>
			
			<label>Transaction Type</label>
			<select class="form-control" name="search_transaction_type" id="search_transaction_type">
			<option value= "Null"> Please Select </option>
			<option value= "%"> All</option>
			<?php $search_transaction_type= $transaction_types?>
						
						
						<?php foreach ($search_transaction_type as $key => $value):	
						if ($url_trantype==$value){
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
						
					
				    	$q = "SELECT * FROM userlistqrt WHERE TeamLeader = 1";
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
						
			<button type="submit" name="Read_From_Database" class="btn btn-default">Search From Database</button>
			<br>
			<?php 
		
						 // if the page is already existed and opened, then show only that record.
							if (isset($_GET['form_id'])){
								$form_id = $_GET['form_id'];
								$q = "SELECT * FROM review WHERE form_id = '$form_id'";
							
							
							$r5 = mysqli_query($dbc,$q);
							$result=mysqli_fetch_assoc($r5);
							$case_number = $result['case_number'];
							//$select_name = $result['AT_TCH'];
							
							echo '<div class = "form-control" id="serach_result">';
							echo "<ul>";
							
							
								echo "<li><a href = 'index.php?form_id=".$form_id."'>". "$case_number"."</a></li>";
							
							echo "</ul>";
							echo "</div>";
						}else{
							$select_product_type = $_POST['search_product_type'];
							$select_trans=$_POST['search_transaction_type'];
							$select_reviewer = $_POST['search_reviewer'];
							$select_reviewee=$_POST['search_reviewee'];
													
							error_log( "search box select reviewee is: ".$search_reviewee);
							$q= "SELECT * FROM review WHERE product_type LIKE '$select_product_type' AND transaction_type LIKE '$select_trans' AND reviewer_id LIKE '$select_reviewer' AND reviewee_id LIKE'$select_reviewee' GROUP BY 'case_number'";
							error_log ("serach inquiry is ". $q);
							$r = mysqli_query($dbc, $q);
							if (mysqli_num_rows($r) == 0){
								
									echo ("<h4>There is no matching record of your search criterial</h4>");
								 }
							else{ 
									$current_rec = null;
									
									echo '<div id="serach_result">';
									echo "<ul>";
									foreach ($r as $current_rec){
										error_log ("the form id is: ". $current_rec['form_id']);
										$href="index.php?form_id=".$current_rec['form_id']."&trans=".urlencode($current_rec['transaction_type'])."&product=".urlencode($current_rec['product_type']);
										echo "<li><a href = $href>". $current_rec['case_number']."</a></li>";
									}
								echo "</ul>";
								echo "</div>";
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