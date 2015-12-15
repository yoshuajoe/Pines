<?php
	if (isset($_POST['sql'])) {

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=filter.csv');
		
		$output = fopen('php://output', 'w');

		fwrite($output, "id,created_at,picture,source,screen_name,name,text,time_zone,clean_text \n");
		$username = "root";
		$password = "";
		$hostname = "127.0.0.1"; 
		$dbhandle = mysql_connect($hostname, $username, $password) 
						 or die("Unable to connect to MySQL");
						//echo "Connected to MySQL<br>";

						//select a database to work with
		$selected = mysql_select_db("datamining",$dbhandle) 
						  or die("Could not select examples");
		$rows = mysql_query($_POST['sql']);
		#print($_POST['sql']);
		
		while ($row = mysql_fetch_array($rows)) {
			fwrite($output, "\"".$row['id']."\"".",".$row['created_at'].",".$row['picture'].",".
			str_replace(array("\n", "\t", "\r"), "\\\'", $row['source']).",".
			str_replace(array("\'"), "\\\'", $row['screen_name']).",".
			str_replace(array("\'"), "\\\'", $row['name']).",".
			str_replace(array("\n", "\t", "\r", "&amp;",";",","), "", $row['text']).",".
			str_replace(array("\'"), "\\\'", $row['time_zone']).",".
			str_replace(array("\n", "\t", "\r","&amp;",";",","), "", $row['text_clean'])."\n");
		}
		fclose($output);
		mysql_close($dbhandle);
		exit();
		
	}
?>