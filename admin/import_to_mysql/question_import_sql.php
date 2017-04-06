<?PHP


$dbc = mysqli_connect('eco71147','shirley','','rpc_qrt') or die('Could not connect because:'.mysqli_connect_error());


$fp = fopen('C:\xampp\htdocs\rpc_qrt\admin\import_to_mysql\question.csv','r') or die("can't open file");
$line = 1;
while($csv_line = fgetcsv($fp,1024)) {
    print "Line Number: " . $line++ . PHP_EOL;
	//if((0 === preg_match('~[0-9]~', $csv_line[0]))&& strlen($csv_line[0])==3){
		$q = "INSERT question (product_type, transaction_type,section,question_name) values('$csv_line[0]', '$csv_line[1]', '$csv_line[2]', '$csv_line[3]')";
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
		
	//}

}


		
fclose($fp) or die("can't close file");/*


?>