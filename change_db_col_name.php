<?php
$conn = mysqli_connect('eco72648', 'shirley', '');
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}
mysqli_select_db($conn,'qrt');
$result = mysqli_query($conn,'SHOW COLUMNS FROM intakereviewtable');
if (!$result) {
    die('Query failed: ' . mysqli_connect_error());
}
/* get column metadata */
$i = 0;
/* $fields = array();
$new_fields = array(); */
while ($i < mysqli_num_rows($result)) {
 
    $row = mysqli_fetch_assoc($result);
	
	
    if (!$row) {
        echo "No information available<br />\n";
    }
	$old_field=$row['Field'];
	$data_type = $row['Type'];
	
	if($i < 8){
		$new_field = $old_field;
	}else{
		$new_field = strtoupper($old_field);
		//$new_field = ucwords(strtolower($old_field), "_");
	}
	
	
    //print_r ($row['Field']);
	//echo ("\n");
	
	print_r ("in old fields array, the name is ".$row['Field']);
	echo ("\n");
	
	print_r ("in new fields array, the name is ".$new_field);
	echo ("\n");
   
	
	$q="ALTER TABLE intakereviewtable CHANGE $old_field $new_field $data_type;";
	echo $q;
	echo ("\n");
	$result_1 = mysqli_query($conn,$q);
	if (!$result_1) {
    die('Query failed: ' . mysqli_connect_error());
	}
	
	 $i++;
}
mysqli_free_result($result);
//mysqli_free_result($result_1);
?>