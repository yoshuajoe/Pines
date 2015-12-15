<?php
	if (isset($_POST['sql'])) {

		header('Content-Type: text/json; charset=utf-8');
		header('Content-Disposition: attachment; filename=filter.json');
		
		$output = fopen('php://output', 'w');
		
		$attr = array();
		if(isset($_POST['attribute']))
		{
			$attr = explode(",",$_POST['attribute']);
		}
		
		//fputcsv($output, array('id', 'created_at', 'picture', 'source', 'screen_name', 'name', 'text', 'time_zone'));
	
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
		#print( $_POST['sql']);
		#print_r($rows);
		
		while ($row = mysql_fetch_array($rows)) {
			$ctext = $row['text'];
			$arr = array(
							'id' => $row['id'],
							'created_at' => $row['created_at'],
							'picture' => $row['picture'],
							'source' => $row['source'],
							'favorited' => $row['favorited'],
							'retweet_count' => $row['retweet_count'],
							'text' => $row['text'],
							'text_clean' => $row['text_clean'],
							'screen_name' => $row['screen_name'],
							'name' => $row['name'],
							'friends_count' => $row['friends_count'],
							'followers_count' => $row['followers_count'],
							'statuses_count' => $row['statuses_count'],
							'verified' => $row['verified'],
							'utc_offset' => $row['utc_offset'],
							'time_zone' => $row['time_zone'],
							'in_reply_to_screen_name' => $row['in_reply_to_screen_name'],
							'tracker' => $row['tracker'],
							'is_active' => $row['is_active'],
							'polarity' => $row['polarity'],
							'timestamps' => $row['timestamps']
						);
			fwrite($output,json_encode($arr)."\n");
		}
		fclose($output);
		mysql_close($dbhandle);
		exit();
	}
?>