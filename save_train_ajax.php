<?php
	if (isset($_POST['id']) && isset($_POST['polar'])) {
		$username = "root";
		$password = "";
		$hostname = "127.0.0.1"; 
		
		$dbhandle = mysql_connect($hostname, $username, $password) 
					 or die("Unable to connect to MySQL");
					//echo "Connected to MySQL<br>";

		//select a database to work with
		$selected = mysql_select_db("datamining",$dbhandle) 
		  or die("Could not select examples");
		//execute the SQL query and return records
		
		$sql = "UPDATE tweets_train SET polarity='".$_POST['polar']."' WHERE id='".$_POST['id']."'";
		
		$res = mysql_query($sql);
	
		
		mysql_close($dbhandle);
		
		if($res)
		{
			echo "stored";
		}else
		{
			echo "failed";
		}
		
	}
?>