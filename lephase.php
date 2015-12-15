<html>  
<head>    
    <title>Twitter Analysis | Learning phase</title>
    <script type="text/javascript" src="jquery-1.11.3.js"></script>
	<script type="text/javascript" src="jquery.tabletojson.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="css/card.css" rel="stylesheet" type="text/css">
	<style>
	h3, h4, h5 {
		   border: none;
		}
		.bs-callout+.bs-callout {
			margin-top: -5px;
		}
		.bs-callout-info {
			border-left-color: #1b809e;
		}
		.bs-callout {
			padding: 20px;
			margin: 20px 0;
			border: 1px solid #eee;
			border-left-width: 5px;
			border-radius: 3px;
		}
		.btn-warning
		{
			color:#fff;
		}
		.btn-default
		{
			background-color:#ccc;
			color:#fff;
			border-color:transparent;
		}
		*{
			color:grey;
		}
		input[type=text],
		input[type=text]:hover,
		input[type=text]:focus,
		input[type=text]:active
		{
			color:grey;
			border: 0;
			outline: none;
			outline-offset: 0;
		}
		.btn-file {
			position: relative;
			overflow: hidden;
		}
		.btn-file input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			filter: alpha(opacity=0);
			opacity: 0;
			outline: none;
			background: white;
			cursor: inherit;
			display: block;
		}
		@include keyframes(bounce) {
			0%, 20%, 50%, 80%, 100% {
			@include transform(translateY(0));
		  }
			40% {
			@include transform(translateY(-30px));
		  }
			60% {
			@include transform(translateY(-15px));
		  }
		}
	</style>
</head>
<body>
<?php 
	parse_str($_SERVER["QUERY_STRING"], $query_array);
	
	ini_set('max_execution_time', 3000000);
	
	$username = "root";
	$password = "";
	$hostname = "127.0.0.1"; 
			
	//connection to the database
	$dbhandle = mysql_connect($hostname, $username, $password) 
		or die("Unable to connect to MySQL");
	//echo "Connected to MySQL<br>";

	//select a database to work with
	$selected = mysql_select_db("datamining",$dbhandle) 
		or die("Could not select examples");
	//execute the SQL query and return records
	

	// TRAIN THE MACHINE
	// INTEGRATING WITH PYTHON CODE	
	if(isset($_GET['ready']))
	{
		$sql_pos = "select * from tweets_train WHERE tracker='".$query_array['tracker']."' 
						AND polarity='positif'";
						
		$sql_neg = "select * from tweets_train WHERE tracker='".$query_array['tracker']."' 
						AND polarity='negatif'";
						
		$sql_net = "select * from tweets_train WHERE tracker='".$query_array['tracker']."' 
						AND polarity='netral'";
		
		$res_pos = mysql_query($sql_pos);
		$res_net = mysql_query($sql_net);
		$res_neg = mysql_query($sql_neg);
		
		$arr = array(array());
		$p = 0;
		$f = fopen("data/data_train_machine/positif/positif.json", "w");
		while($row = mysql_fetch_array($res_pos))
		{
			$arr[$p] = array(
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
				$p++;
		}
		fwrite($f, json_encode($arr));
		fclose($f);
		
		$arr = array(array());
		$p = 0;
		$f = fopen("data/data_train_machine/negatif/negatif.json", "w");
		while($row = mysql_fetch_array($res_neg))
		{
			$arr[$p] = array(
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
				$p++;
		}
		fwrite($f, json_encode($arr));
		fclose($f);
		
		
		$arr = array(array());
		$p = 0;
		$f = fopen("data/data_train_machine/netral/netral.json", "w");
		while($row = mysql_fetch_array($res_net))
		{
			$arr[$p] = array(
							'id' => $row['id'],
							'created_at' => $row['created_at'],
							'picture' => $row['picture'],
							'source' => $row['source'],
							'favorited' => $row['favorited'],
							'retweet_count' => $row['retweet_count'],
							'text' => $row['text'],
							'text_clean' => $row['text_clean'],
							'screen_name' => $row['screen_name'],
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
				$p++;
		}
		fwrite($f, json_encode($arr));
		fclose($f);
		
		$trun = "TRUNCATE TABLE word_weight";
		mysql_query($trun);
		
		#print("halo");
		$command = 'C:/Users/Yoshua/Anaconda/python.exe c:/xampp/htdocs/experiment/class_2.py > halo.txt';
		#print($command);
		$output = exec($command);
		#print_r($output);
		
		$get_config = "SELECT * FROM cleanse_config WHERE tracker='".$query_array['tracker']."'";
		$res_get_conf = mysql_query($get_config);
		$res_conf = mysql_fetch_array($res_get_conf);

		$sql = "select * from tweets ";
		$sql_count = "select count(*) as semua from tweets ";					
		$flagWhere = 0;
					
		if(isset($res_conf['query']) && strlen($res_conf['query']) > 0)
		{
			if($flagWhere == 0)
			{
				$sql .= " WHERE ";
				$sql_count .= " WHERE ";
				$flagWhere = 1;
			}
			
			$arr_spl = explode(",", $res_conf['query']);
			for($p = 0; $p < count($arr_spl); $p++)
			{
				if($p > 0)
				{
					$sql .= " AND ";
					$sql_count .= " AND ";
				}
				$sql .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
				$sql_count .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
				
			}
		}
					
		if(isset($res_conf['source']) && strlen($res_conf['source']) > 0)
		{
			if($flagWhere == 0)
			{
				$sql .= " WHERE ";
				$sql_count .= " WHERE ";
				$flagWhere = 1;
			}
			
			$arr_spl = explode(",", $res_conf['source']);
			for($p = 0; $p < count($arr_spl); $p++)
			{
				if(isset($res_conf['query']) && strlen($res_conf['query']) > 0 
					|| $p > 0)
				{
					$sql .= " AND ";
					$sql_count .= " AND ";
				}
				
				$sql .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
				$sql_count .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
			}
		}
					
		if(isset($query_array['tracker']) && strlen($query_array['tracker']) > 0)
		{
			if($flagWhere == 0)
			{
				$sql .= " WHERE ";
				$sql_count .= " WHERE ";
				$flagWhere = 1;
			}
			
			if(isset($res_conf['source']) && strlen($res_conf['source']) > 0 
				|| isset($res_conf['query']) && strlen($res_conf['query']) > 0)
				{
					$sql .= " AND ";
					$sql_count .= " AND ";
				}
			
			$sql .= " tracker = '".trim($query_array['tracker'])."'";
			$sql_count .= " tracker = '".trim($query_array['tracker'])."'";
		}
					
		#$sql_dw = $sql;
		
		#$sql .= " limit ".(($curr_page-1)*100).",100";
		//echo 'Easy it\'s not harmful, it\'s a debug mode (ask the programmer politely why this text is appearing): <br/> '.$sql;
		
		
		$result = mysql_query($sql);
		$count = mysql_query($sql_count);
		//print_r($sql_count);
		
		$banyaknya = mysql_fetch_array($count)[0];	

		while($data = mysql_fetch_array($result))
		{
			$spct = explode(" ", $data['text_clean']);
			$polar = "";
			$hit_pos = $hit_neg = $hit_net = 1.00;
			try{
				error_reporting(E_ERROR | E_PARSE);
				for($pi=0; $pi < count($spct); $pi++)
				{
					$get_weight = "SELECT * FROM word_weight WHERE word='".$spct[$pi]."'";
					#print($get_weight);
					$res_we = mysql_query($get_weight);
					$arr_we = mysql_fetch_array($res_we);
					$hit_pos *= floatval($arr_we['pos']); 
					$hit_neg *= floatval($arr_we['neg']); 
					$hit_net *= floatval($arr_we['net']); 
				}
			}catch(Exception $e)
			{
				
			}
					
			$arr_res = array($hit_pos, $hit_neg, $hit_net);
			arsort($arr_res);
			
			if($arr_res[0] == $hit_net)
			{
				$polar = "netral";
			}else if($arr_res[0] == $hit_pos)
			{
				$polar = "positif";
			}else if($arr_res[0] == $hit_neg)
			{
				$polar = "negatif";
			}
			
			$sql_update = "UPDATE tweets SET polarity='".$polar."' WHERE id='".$data['id']."'";
			$res_update = mysql_query($sql_update);
		}					
	}

	
?>
	<section class="featured" style="padding:80px 0 40px">
		<div class="container"> 
			<div class="row mar-bot40">
				<div class="col-md-6 col-md-offset-3">	
					<div class="align-center">
						<h2 class="slogan">Machine Learning Phase</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="section-services" class="section pad-bot30 bg-white">
		<div class="container"> 
			<h4>What will you do:</h4>
			<ol>
				<li>Choose topic</li>
				<li>Just click <code>I'm super ready</code></li>
				<li>Then machine will does its task</li>
			</ol>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<h4>How to use</h4>
			<p>Just tell us the topic you want to load i.e <code>ahok</code>. Then click the <code>I'm super ready</code>.<br/>Note : Uppercase and lowercase doesn't matter.</p>
		</div>

		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<div class="row">&nbsp;</div>
			<h4>Choosing the Topic</h4>
			<p>We stored some topics in our database, so select one of them to be loaded.</p>
			<form method="GET" action="lephase.php?tracker=<?php echo $query_array['tracker'];?>">
			<div class="input-group">
				<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-default" style="background-color:#fff;color:#000" type="button">Which topics&nbsp;</button>
				</span>
				<input type="text" name="tracker" class="form-control"  placeholder="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; else echo "topics"; ?>" 
					value="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; ?>">
				</div>
			</div>
			<div>
				<input type="hidden" name="page" value="<?php if(isset($query_array['page'])) echo $query_array['page']; else echo 1;?>"/>
									
				<input type="submit" id="gen" name="ready" class="btn btn-primary pull-right" style="margin-right:1%" value="I'm super ready" />
			</div>
		</form>	
		
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
	</div>
	<div class="container">
		<div class="col-lg-12">
		<h4>List of Tweets</h4>
		<p>Here is the tweets loaded from the information you gave.</p>
		
		<?php
					 
			$sql_dw = '';
			if(isset($query_array['page']))
			{
				$curr_page = $query_array['page'];
			}else
			{
				$curr_page = 1;
			}

			$sql = "select * from tweets ";
			$sql_count = "select count(*) as semua from tweets ";					
			$flagWhere = 0;
						
			if(isset($query_array['tracker']) && strlen($query_array['tracker']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql .= " WHERE ";
					$sql_count .= " WHERE ";
					$flagWhere = 1;
				}
							
				$sql .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_count .= " tracker = '".trim($query_array['tracker'])."'";
			}
			
			$sql_dw = $sql;
			
			$sql .= " limit ".(($curr_page-1)*100).",100";
			#echo 'Easy it\'s not harmful, it\'s a debug mode (ask the programmer politely why this text is appearing): <br/> '.$sql;
			
			
			$result = mysql_query($sql);
			$count = mysql_query($sql_count);
			#print_r($sql_count);
			
			$banyaknya = mysql_fetch_array($count)[0];
			
			$i = 0;
			//fetch tha data from the database 
			while ($row = mysql_fetch_array($result)) 
			{
				$i++;
				
			?>
				<div class="col-md-4 col-sm-6">
		      	 <div class="panel panel-default">
		           <div class="panel-heading"><a href="#" class="pull-right"><?php echo substr($row{'created_at'}, 0, 11); ?></a> <h4 style=" border: 0 solid #efefef;
	    border-bottom-width: 1px;
	    padding-bottom: 10px;"><?php echo $row{'name'}; ?> - <?php echo substr($row{'id'}, 0, 11); ?></h4>
		           </div>
		   			<div class="panel-body">
		              <p><img src="<?php echo $row{'picture'}; ?>" class="img-circle pull-right"> <a href="#"><?php echo "@".$row{'screen_name'}; ?></a></p>
		              <div class="clearfix"></div>
		              <hr>
		              <?php echo $row{'text'}; ?><br/>
		              <div style=" border: 0 solid #efefef;border-bottom-width: 1px;margin-bottom:10px;padding-bottom: 10px;padding-top: 10px;">
	    			  <?php echo $row{'text_clean'}; ?> <br/>
					  </div>
		              <?php echo $row{'source'}; ?> - <?php echo $row{'time_zone'} . "&nbsp;&nbsp;&nbsp;&nbsp;" ; ?>

			      	 <?php 
			      	 		if($row['polarity'] == "positif")
			      	 		{
			      	 			echo "<button class='btn btn-success'>Positif</button>";
			      	 		} else if($row['polarity'] == "negatif")
			      	 		{
			      	 			echo "<button class='btn btn-danger'>Negatif</button>";
			      	 		} else 
			      	 		{
			      	 			echo "<button class='btn btn-warning'>Netral</button>";
			      	 		}

			      	 	?>	
		              </div>
			         </div> 
			    </div>
				<?php
					}
					//close the connection
					mysql_close($dbhandle);
				?>
		</div>
		<div class="pull-right" style="display:inline">
			<form action="csv_cleanse.php" style="float:left" target="_blank" method="post">
				<input type="text" style="display:none" name="sql" value="<?php echo $sql_dw; ?>" />
								
				<input type="submit" class='btn btn-success' value="Export to CSV &nbsp;" />
			</form>
			<form action="json_cleanse.php" style="float:left" target="_blank" method="post">
				<input type="text" style="display:none" name="sql" value="<?php echo $sql_dw; ?>" />
				<input type="submit" class='btn btn-warning' value="Export to JSON" />
			</form>
		</div>
		<div class="pull-left">
			<h5><span style='background-color:grey;padding:1%;color:#fff;border-radius:5%'>Current page : <?php if(isset($query_array['page'])) echo $query_array['page']; else echo $curr_page; ?></span></h5>
			<nav>
			  <ul class="pagination">
				<?php 
					for($j=1; $j < (($banyaknya/100)+1); $j++)
					{	
						if(isset($query_array['tracker']) && isset($query_array['page']))
							echo "<li><a href='lephase.php?tracker=".$query_array['tracker']."&page=".$j."'>".$j."</a></li>";
						else
							echo "<li><a href='lephase.php?page=".$j."'>".$j.
						"</a></li>";
					}
				?>
			  </ul>
			</nav>
		</div>
		</div>
		</section>
		<!-- END OF 12 -->
		</div>
		<div class="row">
		</div>
	</div>
</body>
<script type="text/javascript">
	function store(x, a, e)
	{
		$.ajax({
		  type: "POST",
		  url: "http://localhost:8090/experiment/save_train_ajax.php",
		  data: {"id":a, "polar":e},
		  success: function(data){
			   alert(data);
			  if(data != "failed")
			  {
				 $(this).parent().parent().parent().parent().slideUp(500);
			  }
		  },
		  error:function(data){
			  if(data.responseText != "failed")
			  {
				 $(x).parent().parent().parent().parent().slideUp(500);
			  }
		  },
		  dataType: "json"
		});
	}
	
	$(document).ready(function(){
		
		
	});
</script>
</html> 