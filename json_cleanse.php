<?php
	if (isset($_POST['sql'])) {

		header('Content-Type: text/json; charset=utf-8');
		header('Content-Disposition: attachment; filename=filter.json');
	
		// read the file
		$punctuation_dict = array();
		$normalize_dict = array();
		$stopword_dict = array();
		$numbers_dict = array();
		
		$file = fopen("data/punctuation.txt","r");
		while(!feof($file))
		{
			$line=fgets($file);
			$line_arr= explode(",",$line);
			for($p=0; $p<count($line_arr); $p++)
			{
				$punctuation_dict[$p] = $line_arr[$p];
			}
		}
		fclose($file);
		
		$file = fopen("data/numbers.txt","r");
		while(!feof($file))
		{
			$line=fgets($file);
			$line_arr= explode(",",$line);
			for($p=0; $p<count($line_arr); $p++)
			{
				$numbers_dict[$p] = $line_arr[$p];
			}
		}
		fclose($file);
		
		$file = fopen("data/normalize.txt","r");
		while(!feof($file))
		{
			$line=fgets($file);
			$line_arr = explode(",",$line);
			for($p=0; $p<count($line_arr); $p++)
			{
				$normalize_dict[$p] = $line_arr[$p];
			}
		}
		#print_r($normalize_dict);
		fclose($file);
		
		$file = fopen("data/stopword.txt","r");
		while(!feof($file))
		{
			$line=fgets($file);
			$line_arr= explode(",",$line);
			for($p=0; $p<count($line_arr); $p++)
			{
				$stopword_dict[$p] = $line_arr[$p];
			}
		}
		fclose($file);
		
		$output = fopen('php://output', 'w');
		
		$attr = array();
		if(isset($_POST['attribute']))
		{
			$attr = explode(",",$_POST['attribute']);
		}
		
		//fputcsv($output, array('id', 'created_at', 'picture', 'source', 'screen_name', 'name', 'text', 'time_zone'));
		$con = mysqli_connect('127.0.0.1', 'root', '', 'datamining');
		$rows = mysqli_query($con, $_POST['sql']);
		while ($row = mysqli_fetch_assoc($rows)) {
			$ctext = $row['text'];
			if(isset($_POST['attribute'])){
				$ctext = $row['text'];
				if(in_array('url', $attr))
				{
					$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
					$ctext = preg_replace($regex, '', $ctext);
				}
				
				if(in_array('punctuation', $attr))
				{
					$re = "/[";
					for($p=0; $p<count($punctuation_dict); $p++)
					{
						$re .= $punctuation_dict[$p];
					}
					$re .= "]+/u";
					$ctext = preg_replace($re, "", $ctext);
					#$ctext = preg_replace("/(?![@#])\p{P}/u", "", $ctext);
				}
				
				if(in_array('numbers', $attr))
				{
					$re = "/[";
					for($p=0; $p<count($numbers_dict); $p++)
					{
						$re .= $numbers_dict[$p];
					}
					$re .= "]+/u";
					$ctext = preg_replace($re, "", $ctext);
					#$ctext = preg_replace('/[0123456789]+/', '', $ctext);
				}
				
				if(in_array('stopword', $attr))
				{
					$re = "/(";
					for($p=0; $p<count($stopword_dict); $p++)
					{
						$re .= "\b".$stopword_dict[$p]."\b";
						if($p < count($stopword_dict)-1)
						{
							$re .= "|";
						}
					}
					$re .= ")/i";
					#print($re);
					$ctext = preg_replace($re, "", $ctext);
					#$ctext = preg_replace('/[0123456789]+/', '', $ctext);
				}
				
				if(in_array('normalize', $attr))
				{
					
					for($p=0; $p<count($normalize_dict); $p++)
					{
						$re = "/(";
						$exp = explode("=", $normalize_dict[$p]);
						#print_r($exp);
						$re .= "\b".$exp[0]."\b";
						$re .= ")/i";
						$ctext = preg_replace($re, $exp[1], $ctext);
					}
					
					#print($re);
					
					#$ctext = preg_replace('/[0123456789]+/', '', $ctext);
				}
				
				if(in_array('lowercase', $attr))
				{
					$ctext = strtolower($ctext);
				}
			}
			$row['text_clean'] = $ctext;
			fwrite($output,json_encode($row)."\n");
		}
		fclose($output);
		mysqli_close($con);
		exit();
	}
?>