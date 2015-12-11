<html>  
<head>    
    <title>Twitter Analysis | Raw Tweet Selection</title>
    <script type="text/javascript" src="jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="jquery.tabletojson.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
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
	</style>
</head>
<body>
<?php 
	parse_str($_SERVER["QUERY_STRING"], $query_array);
?>
	<div class="container-fluid">
		<div class="bs-callout bs-callout-info" id="callout-navbar-breakpoint">
			<h4>How to use</h4>
			<p>This is an apps to exclude the raw tweets. Sample usage <code>uang,korupsi,jujur</code> note : Uppercase and lowercase doesn't matter. Don't forget one instruction per line, never doing this. Use the textbox below</p>
			<form method="GET" action="filter.php?page=1">
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Without&nbsp;&nbsp;&nbsp;</button>
					</span>
					<input style="backround:transparent" type="text" name="query" class="form-control"  placeholder="<?php if(isset($query_array['query'])) echo $query_array['query']; else echo "Exclude..."; ?>" 
					value="<?php if(isset($query_array['query'])) echo $query_array['query']; else echo ""?>">
				</div>
				<div class="row">&nbsp;</div>
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-success" type="button">No From&nbsp;</button>
					</span>
					<input type="text" name="source" class="form-control"  placeholder="<?php if(isset($query_array['source'])) echo $query_array['source']; else echo "Banned the source"; ?>" 
					value="<?php if(isset($query_array['source'])) echo $query_array['source']; ?>">
				</div>
				<div class="row">&nbsp;</div>
				<div class="input-group">
					<span class="input-group-btn">
						<h3>Which topic ..&nbsp;</h3>
					</span>
					<div class="row">&nbsp;</div>
					<input type="text" style="text-deoration:none;width:30%;padding:2%;font-size:16pt;color:gray;" name="tracker" class="form-control" 
					value="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; ?>">
				</div>
				<div>
					<input type="hidden" name="page" value="<?php if(isset($query_array['page'])) echo $query_array['page']; else echo 1;?>"/>					
					<input type="submit" id="gen" class="btn btn-primary pull-right" style="margin-right:1%" value="Submit" />
				</div>
			</form>	
			<br/>
		</div>
		<table class="table table-hover table-responsive" id="content" style="font-size:12pt">
			<tr>
				<th>no</th>
				<th>picture</th>
				<th>id</th>
				<th>created_at</th>	
				<th>source</th>	
				<th>screen_name</th>
				<th>name</th>
				<th>text</th>
				<th>time_zone</th>
			</tr>
			<tbody id="lst">
				<?php
					function call_curl($headers, $method, $url, $data)
					{			
						$handle = curl_init();
						curl_setopt($handle, CURLOPT_URL, $url);
						curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
						#curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
						#curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
						 
						switch($method) {
							case 'GET':
								break;
							case 'POST':
								curl_setopt($handle, CURLOPT_POST, true);
								curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
								break;
							case 'PUT': 
								curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
								curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
								break;
							case 'DELETE':
								curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
								break;
						}
						
						$response = curl_exec($handle);
						$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
						curl_close($handle);
						print($code);
						#print($response);
						return $response;
					}
				
					$username = "root";
					$password = "";
					$hostname = "127.0.0.1"; 
					$sql_dw = '';
					if(isset($query_array['page']))
					{
						$curr_page = $query_array['page'];
					}else
					{
						$curr_page = 1;
					}
					//connection to the database
					$dbhandle = mysql_connect($hostname, $username, $password) 
					 or die("Unable to connect to MySQL");
					//echo "Connected to MySQL<br>";

					//select a database to work with
					$selected = mysql_select_db("datamining",$dbhandle) 
					  or die("Could not select examples");
					//execute the SQL query and return records
					
					if(isset($_FILES['file_hadoop']))
					{
						$target_dir = "uploads/";
						$target_file = $target_dir . basename($_FILES["file_hadoop"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
						// Allow certain file formats
						if($imageFileType != "txt" && $imageFileType != "json" && $imageFileType != "csv") {
							echo "Sorry, only txt, json, csv files are allowed.";
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							echo "Sorry, your file was not uploaded.";
						// if everything is ok, try to upload file
						} else {
							if (move_uploaded_file($_FILES["file_hadoop"]["tmp_name"], $target_file)) {
								echo "The file ". basename( $_FILES["file_hadoop"]["name"]). " has been uploaded.";
								echo "Upload: " . $_FILES["file_hadoop"]["name"] . "<br />";
								echo "Type: " . $_FILES["file_hadoop"]["type"] . "<br />";
								echo "Size: " . ($_FILES["file_hadoop"]["size"] / 1024) . " Kb<br />";
								echo "Stored in: " . $target_file;
								$header = array("Content-Type: application/octet-stream");
								$data = array();
								$method = "PUT";
								$url = "http://10.11.22.102:14000/webhdfs/v1/user/flume/filter/".basename($_FILES["file_hadoop"]["name"])."?op=CREATE&overwrite=true&blocksize=1048576&permission=777&buffersize=1024&user.name=flume"; 
								print($url);
								$call_1 = call_curl($header, $method, $url, $data);
								print_r($call_1);
								$data = "@c:/xampp/htdocs/experiment/".$target_file;
								#print_r($data);
								$call_2 = call_curl($header, $method, $url, $data);
								print_r($call_2);
								
							} else {
								echo "Sorry, there was an error uploading your file.";
							}
						}
					}
					
					if(isset($query_array['query'])) 
					{
						$arr = array();
						$src_arr = array();
						
						if(isset($query_array['query']))
							$arr = explode(",",$query_array['query']);
						
						if(isset($query_array['source']))
							$src_arr = explode(",",$query_array['source']);
						
						if(isset($query_array['query']) && strlen($query_array['query']) > 0) 
							$sql = "select * from tweets ";
						else
							$sql = "select * from tweets ";
						
						if((isset($query_array['query']) && strlen($query_array['query']) > 0))
						{
							$sql .=" WHERE ";
							$sql_count .=" WHERE ";
						}
						else if((isset($query_array['source']) && strlen($query_array['source']) > 0))
						{
							$sql .=" WHERE ";
							$sql_count .=" WHERE ";
						}
						
						else if((isset($query_array['tracker']) && strlen($query_array['tracker']) > 0))
						{
							$sql .=" WHERE ";
							$sql_count .=" WHERE ";
						}
						#$sql = "select * from tweets WHERE text NOT LIKE('%".trim($arr[0])."%') ";
						$sql_count = "select count(*) as semua from tweets WHERE text NOT LIKE('%".trim($arr[0])."%')";
						
						if(isset($query_array['source']) && strlen($query_array['source']) > 0)
						{
							$sql .= " source NOT LIKE ('%".trim($src_arr[0])."%')";
						}
						
						if(isset($query_array['source']) && strlen($query_array['source']) > 0)
						{
							for($g = 0; $g < count($arr); $g++)
							{
								if($g > 0)
								{
									$sql .=" AND ";
									$sql_count .=" AND ";
								}
								$sql .= " text NOT LIKE ('%".trim($arr[$g])."%')";
								$sql_count .= " text NOT LIKE ('%".trim($arr[$g])."%')";
								
							}
						}
						
						for($g = 1; $g < count($src_arr); $g++)
						{
							
							$sql .= " AND source NOT LIKE ('%".trim($src_arr[$g])."%')";
							$sql_count .= " AND source NOT LIKE ('%".trim($src_arr[$g])."%')";
							
						}
						if(isset($query_array['tracker']) && strlen($query_array['tracker']) > 0)
						{
							$sql_count .= " AND tracker='".trim($query_array['tracker'])."'";
							$sql .= " AND tracker='".trim($query_array['tracker'])."' ";
						}
						
						$sql_dw = $sql;
						$sql .= " limit ".(($curr_page-1)*100).",100";
						echo 'Easy it\'s not harmful, it\'s a debug mode (ask the programmer politely why this text is appearing): <br/> '.$sql;
						$result = mysql_query($sql);
						$count = mysql_query($sql_count);
						$banyaknya = mysql_fetch_array($count)[0];
					}
					else
					{
						$sql = "select * from tweets limit ".(($curr_page-1)*100).",100";
						$sql_dw = "select * from tweets";
						$result = mysql_query($sql);
						$count = mysql_query("select count(*) as semua from tweets");
						$banyaknya = mysql_fetch_array($count)[0];
					}
					
					$i = 0;
					//fetch tha data from the database 
					while ($row = mysql_fetch_array($result)) {
						$i++;
				?>
					<tr>
						<td><?php echo $i+($curr_page*10)-10; ?></td>
						<td><img src='<?php echo $row{'picture'}; ?>'/></td>
						<td><?php echo $row{'id'}; ?></td>
						<td><?php echo substr($row{'created_at'}, 0, 11); ?></td>
						<td><?php echo $row{'source'}; ?></td>
						<td><?php echo $row{'screen_name'}; ?></td>
						<td><?php echo $row{'name'}; ?></td>
						<td><?php echo $row{'text'}; ?></td>
						<td><?php echo $row{'time_zone'}; ?></td>
					</tr>
				<?php
					}
					//close the connection
					mysql_close($dbhandle);
				?>
			</tbody>
		<table>
		<div class="pull-right" style="display:inline">
			<form action="csv.php" style="float:left" target="_blank" method="post">
				<input type="text" style="display:none" name="sql" value="<?php echo $sql_dw; ?>" /> 
				<input type="submit" class='btn btn-success' value="Export to CSV &nbsp;" />
			</form>
			<form action="json.php" style="float:left" target="_blank" method="post">
				<input type="text" style="display:none" name="sql" value="<?php echo $sql_dw; ?>" /> 
				<input type="submit" class='btn btn-warning' value="Export to JSON" />
			</form>
			<form id="hdfs" action="filter.php?tracker=<?php if(isset($query_array['tracker'])) echo $query_array['tracker'];?>" style="float:left" enctype="multipart/form-data" method="POST">
				<span class="btn btn-primary btn-file">
					Upload to HDFS <input name="file_hadoop" type="file">
				</span>
			</form>
		</div>
		<div class="pull-left">
			<h5><span style='background-color:grey;padding:2%;color:#fff;border-radius:5%'>Current page : <?php if(isset($query_array['page'])) echo $query_array['page']; else echo $curr_page; ?></span></h5>
			<nav>
			  <ul class="pagination">
				<?php 
					for($j=1; $j < (($banyaknya/100)+1); $j++)
					{	
						if(isset($query_array['tracker']) && isset($query_array['page']) && isset($query_array['query'])  && isset($query_array['source']) )
							echo "<li><a href='filter.php?tracker=".$query_array['tracker']."&page=".$j."&source=".$query_array['source']."&query=".$query_array['query']."'>".$j."</a></li>";
						else
							echo "<li><a href='filter.php?page=".$j."'>".$j."</a></li>";
					}
				?>
			  </ul>
			</nav>
		</div>

	</div>
	</body>
<script type="text/javascript">
	$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label, input) {
        $("#hdfs").submit();
    });
});

$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label, input]);
});
</script>
</html>