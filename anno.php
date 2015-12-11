<html>  
<head>    
    <title>Twitter Analysis | Raw Tweet Selection</title>
    <script type="text/javascript" src="jquery-1.11.3.js"></script>
	<script type="text/javascript" src="jquery.tabletojson.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<style>
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
	
	
	$basedir = "c:/xampp/htdocs/experiment/data/";
	$src = glob($basedir.'data_train/*.json');;
	$dst = glob($basedir."/data_train_settle/*"); // get all file names
	$file_settle_count = count($dst);
	if(isset($_POST['ready']))
	{
		foreach($dst as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}		
		
		foreach($src as $file){
			if (!copy($file, "c:/xampp/htdocs/experiment/data/data_train_settle/".substr($file, strlen($basedir."data_train/")))) {
				echo "failed to copy $file...\n";
			}
		}
		
			// input to mysql
					$username = "root";
					$password = "";
					$hostname = "127.0.0.1"; 
					$sql_dw = '';

					//connection to the database
					$dbhandle = mysql_connect($hostname, $username, $password) 
					 or die("Unable to connect to MySQL");
					//echo "Connected to MySQL<br>";

					//select a database to work with
					$selected = mysql_select_db("datamining",$dbhandle) 
					  or die("Could not select examples");
					//execute the SQL query and return records
					
					$truncate = "TRUNCATE TABLE tweets_train";
					$res_truncate = mysql_query($truncate);
					ini_set('max_execution_time', 3000000);
					
					if(isset($_POST['bydate']))
					{
						foreach($dst as $file)
						{ // iterate files
							if(is_file($file))
							{
								$f = fopen($file, "r");
								
								while(!feof($f)) 
								{
									#print(fgets($f));
									#print_r(json_decode(fgets($f), TRUE));
									$data = json_decode(fgets($f), TRUE);
									#print_r($data);
									$sql_insert = "INSERT INTO tweets_train(id,created_at,picture,source,favorited,retweet_count,text, text_clean,screen_name, name,time_zone,tracker, is_active) VALUES('".$data['id']."', '".$data['created_at']."','".$data['picture']."','".$data['source']."', '".$data['favorited']."', ".$data['retweet_count'].", '".$data['text']."', '".$data['text_clean']."', '".$data['screen_name']."','".$data['name']."', '".$data['time_zone']."', '".$data['tracker']."', 'A')";
									$res_insert = mysql_query($sql_insert);
								}
								fclose($f);
							}	
						}	
					}else
					{
						$count = 1;
						foreach($dst as $file)
						{ // iterate files
							if($count == $_POST['k-fold'])
							{
								if(is_file($file))
								{
									$f = fopen($file, "r");
									
									while(!feof($f)) 
									{
										$data = json_decode(fgets($f), TRUE);
										$sql_insert = "INSERT INTO tweets_train(id,created_at,picture,source,favorited,retweet_count,text, text_clean,screen_name, name,time_zone,tracker, is_active) VALUES('".$data['id']."', '".$data['created_at']."','".$data['picture']."','".$data['source']."', '".$data['favorited']."', ".$data['retweet_count'].", '".$data['text']."', '".$data['text_clean']."', '".$data['screen_name']."','".$data['name']."', '".$data['time_zone']."', '".$data['tracker']."', 'A')";
										$res_insert = mysql_query($sql_insert);
									}
									fclose($f);
								}	
							}
							$count++;
						}	
					}
				
					mysql_close($dbhandle);
					
				}
?>
	<section class="featured" style="padding:80px 0 40px">
		<div class="container"> 
			<div class="row mar-bot40">
				<div class="col-md-6 col-md-offset-3">	
					<div class="align-center">
						<h2 class="slogan">Annotating Phase</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="section-services" class="section pad-bot30 bg-white">
	<div class="container">
			<h4>What will you do:</h4>
			<ol>
				<li>Mark the tweets with its tone, whether it is <code>positif, negatif,</code> or <code>netral</code></li>
			</ol>
		</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<h4>How to use</h4>
			<p>Just click and refresh the page through <code>refresh</code> button</p>
		</div>
		<div class="row">&nbsp;</div>
		<div class="container">
		<h4>Annotation Process</h4>
			<form method="POST" action="anno.php?">
				<p>Which method did you use before?</p>
				<div class="btn-group" data-toggle="buttons">
					<label class="btn active">
						<input type="radio" name="bykfold" value="bykfold" > <i>k-</i>fold
						&nbsp;&nbsp;&nbsp;<input type="text" name="k-fold" placeholder="number of chunk (1..<?php echo $file_settle_count; ?>)" />
					</label>
					<label class="btn">
						<input type="radio" name="bydate" value="bydate" > separate by date&nbsp;&nbsp;
					</label>
				</div>
				<div class="row">&nbsp;</div>
				<input type="submit" name="ready" class="btn btn-success" value="I'm ready ">
				<button class="btn btn-primary pull-right"><i style="color:white" class="glyphicon glyphicon-refresh" onclick="location.reload();"></i>&nbsp;refresh</button>
			</form>	
		</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<h4 class="text-center">These are the card of tweets, let's marking</h4>
		</div>
		<div class="row">&nbsp;</div>
		<div class="col-lg-12" style="display:inline;">
		<?php
			$username = "root";
			$password = "";
			$hostname = "127.0.0.1"; 
			$sql_dw = '';

			//connection to the database
			$dbhandle = mysql_connect($hostname, $username, $password) 
			 or die("Unable to connect to MySQL");
			//echo "Connected to MySQL<br>";

			//select a database to work with
			$selected = mysql_select_db("datamining",$dbhandle) 
			  or die("Could not select examples");
			//execute the SQL query and return records
			
			$sql = "SELECT * FROM tweets_train WHERE polarity is NULL LIMIT 10";
			
			$sql_count = "SELECT count(*) as semua FROM tweets_train WHERE polarity is NULL";					
			$count = mysql_query($sql_count);
			$banyaknya = mysql_fetch_array($count)[0];
			$res_get = mysql_query($sql);
			while($row = mysql_fetch_array($res_get))
			{
		?>
			<div class="col-lg-5 pull-left" style="margin-bottom:1%; margin-left:6%; border:1px solid #eee; padding:3%; border-radius:1%">
				<div class="col-lg-1">
					<img src="<?php echo $row{'picture'} ?>" alt="..." class="media-object pull-right">
				</div>
				<div class="col-lg-11">
					<h4><strong><?php echo $row{'name'}?> </strong> -  <?php echo $row{'id'}?> </h4>
					<h5 style="color:#8899a6">@<?php echo $row{'screen_name'}?> - <?php echo $row{'created_at'}?></h5>
					<p style="height:40px"><?php echo $row{'text'}?></p><br/>
					<p style="height:40px"><?php echo $row{'text_clean'}?></p><br/>
					<div class="display:inline">
						<div class="pull-left">
							<button class="btn btn-success positif" onclick="store(this,'<?php echo $row{'id'}?>', 'positif')" ><i style="color:white;font-size:8pt" class="glyphicon glyphicon-heart">&nbsp;</i>positif
							</button>
						</div>
						<div class="pull-left" style="margin-left:1%">
							<button class="btn btn-warning netral" onclick="store(this,'<?php echo $row{'id'}?>', 'netral')"><i style="color:white;font-size:8pt " class="glyphicon glyphicon-certificate">&nbsp;</i>netral
							</button>
						</div>
						<div class="pull-left" style="margin-left:1%">
							<button class="btn btn-danger negatif" onclick="store(this,'<?php echo $row{'id'}?>', 'negatif')" ><i style="color:white;font-size:8pt " class="glyphicon glyphicon-remove">&nbsp;</i>negatif
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php 
			}
			mysql_close($dbhandle);
			
			if($banyaknya ==0)
			{
		?>
			<div class="col-lg-12 pull-left" style="margin-bottom:1%; border:1px solid #eee; padding:2%">
					<center><h2>Congratulation you have finished the anotating process..</h2></center>
					<h2 class="pull-right"> <i class="bounce glyphicon glyphicon-hand-down"></i></h2>
					
			</div>
		<?php
			}
		?>
		</div>
		<div class="container text-center">
			<h4 class="btn btn-lg btn-primary">Untagged items : <?php echo $banyaknya; ?></h4>
			<?php
				if($banyaknya == 0)
				{
			?>
				<div class="pull-right" style="display:inline">
				<form action="csv_cleanse.php" style="float:left" target="_blank" method="post">
					<input type="text" style="display:none" name="sql" value="SELECT * FROM tweets_train" />
					<input type="text" style="display:none" name="attribute" value="<?php echo
										(isset($query_array['punctuation'])?'punctuation':"")
										.(isset($query_array['numbers'])? ',numbers':"")
										.(isset($query_array['url'])? ',url':"")
										.(isset($query_array['normalize'])? ',normalize':"")
										.(isset($query_array['stopword'])? ',stopword':"")
										.(isset($query_array['lowercase'])? ',lowercase':"")?>"/>				
					<input type="submit" class='btn btn-success' value="Export to CSV &nbsp;" />
				</form>
				<form action="json_cleanse.php" style="float:left" target="_blank" method="post">
					<input type="text" style="display:none" name="sql" value="SELECT * FROM tweets_train" />
					<input type="text" style="display:none" name="attribute" value="<?php echo 
										(isset($query_array['punctuation'])?'punctuation':"")
										.(isset($query_array['numbers'])? ',numbers':"")
										.(isset($query_array['url'])? ',url':"")
										.(isset($query_array['normalize'])? ',normalize':"")
										.(isset($query_array['stopword'])? ',stopword':"")
										.(isset($query_array['lowercase'])? ',lowercase':"")?>"/>
					<input type="submit" class='btn btn-warning' value="Export to JSON" />
				</form>
			<?php
				}
			?>
		</div>
	</div>
	</section>
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