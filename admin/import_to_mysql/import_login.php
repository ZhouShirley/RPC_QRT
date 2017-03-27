<?PHP


$dbc = mysqli_connect('eco72648','shirley','','npc_coaching') or die('Could not connect because:'.mysqli_connect_error());


$fp = fopen('C:\xampp\htdocs\coach_NPC\admin\import_to_mysql\sys_user.csv','r') or die("can't open file");
$line = 0;
while($csv_line = fgetcsv($fp,1024)) {
    print "Line Number: " . $line++ . PHP_EOL;
	if((0 === preg_match('~[0-9]~', $csv_line[0]))&& strlen($csv_line[0])==3){
		$user_pass= md5(strtoupper($csv_line[0]));
		$q = "INSERT INTO login_test (char_id,user_pass,full_name) values('$csv_line[0]','$user_pass','$csv_line[35]')";
	error_log($q);
	$r = mysqli_query($dbc,$q);
	if ($r){
		echo "insert successfully";
	}else{
		echo "error";
	}
	for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
            print $csv_line[$i] . PHP_EOL;
			
    }
	}
	
}
fclose($fp) or die("can't close file");

?>