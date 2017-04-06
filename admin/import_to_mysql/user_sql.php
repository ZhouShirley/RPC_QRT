<?PHP


$dbc = mysqli_connect('eco71147','shirley','','rpc_qrt') or die('Could not connect because:'.mysqli_connect_error());


$fp = fopen('C:\xampp\htdocs\rpc_qrt\admin\import_to_mysql\sys_user.csv','r') or die("can't open file");
$line = 0;
while($csv_line = fgetcsv($fp,1024)) {
    print "Line Number: " . $line++ . PHP_EOL;
	if((0 === preg_match('~[0-9]~', $csv_line[0]))&& strlen($csv_line[0])==3){
		$q = "INSERT userlistqrt (3CHID, Manager, AgentName,PrimaryGroup,Email,TeamLeader) values('$csv_line[0]', '$csv_line[5]', '$csv_line[6]', '$csv_line[4]','$csv_line[3]',0)";
		error_log($q);
		$r = mysqli_query($dbc,$q);
		if ($r){
			echo "insert successfully";
		}else{
			echo "error in inserting emp_id";
		}
		for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
				print $csv_line[$i] . PHP_EOL;
				
		}
		
	}

}

/*
$sql = "UPDATE employee e INNER JOIN login_test l ON e.leader_name=l.full_name SET e.leader_id=l.char_id";
error_log($sql);
$r = mysqli_query($dbc,$sql);
if ($r){
	echo "set leader id value in employee table successfully";
}else{
	echo "error in update leader id in employee table";
}
*/
		
fclose($fp) or die("can't close file");

/*
import team leader name
*/
$fp = fopen('C:\xampp\htdocs\rpc_qrt\admin\import_to_mysql\leaders.csv','r') or die("can't open file");
$line = 0;
while($csv_line = fgetcsv($fp,1024)) {
    print "Line Number: " . $line++ . PHP_EOL;
	if((0 === preg_match('~[0-9]~', $csv_line[0]))&& strlen($csv_line[0])==3){
		$q = "INSERT userlistqrt (3CHID, AgentName,PrimaryGroup,Email,TeamLeader) values('$csv_line[0]','$csv_line[5]', '$csv_line[4]','$csv_line[3]',1)";
		error_log($q);
		$r = mysqli_query($dbc,$q);
		if ($r){
			echo "insert successfully";
		}else{
			echo "error in inserting emp_id";
		}
		for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
				print $csv_line[$i] . PHP_EOL;
				
		}
		
	}

}

/*
$sql = "UPDATE employee e INNER JOIN login_test l ON e.leader_name=l.full_name SET e.leader_id=l.char_id";
error_log($sql);
$r = mysqli_query($dbc,$sql);
if ($r){
	echo "set leader id value in employee table successfully";
}else{
	echo "error in update leader id in employee table";
}
*/
		
fclose($fp) or die("can't close file");

?>