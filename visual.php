<html>  
<head>    
    <title>Twitter Analysis | Visualization</title>
    <script type="text/javascript" src="jquery-1.11.3.js"></script>
	<script type="text/javascript" src="jquery.tabletojson.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/d3.min.js"></script>
	<script type="text/javascript" src="js/metricsgraphics.min.js"></script>
	<script type="text/javascript" src="js/d3.layout.cloud.js"></script>
	<script src="http://phuonghuynh.github.io/js/bower_components/d3-transform/src/d3-transform.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/extarray.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/misc.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/micro-observer.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/microplugin/src/microplugin.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/bubble-chart.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/central-click/central-click.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/lines/lines.js"></script>
  <script src="http://dimplejs.org/dist/dimple.v2.1.6.min.js"></script>


  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/metricsgraphics.css" rel="stylesheet" type="text/css" />
	<style>
		.legend circle {
		    fill: none;
		    stroke: #ccc;
		}

		.nav-tabs{
			color:#000;
			border-bottom: none;
		}

		.nav li 
		{
			height: 15%;
		}

		.nav>li>a 
		{
			color:steelblue;
		}

		.nav a :hover
		{
			color:#000;
		}

		text
		{
			font-size: 16pt;
			font-weight: 700;
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
		
		.bubbleChart {
		  min-width: 100px;
		  max-width: 700px;
		  height: 700px;
		  margin: 0 auto;
		}
		
		.bubbleChart svg{
		  background: inherit;
		}
		
		.bar {
		  fill: steelblue;
		}

		.bar:hover {
		  fill: brown;
		}

		.axis {
		  font: 10px sans-serif;
		}

		.axis path,
		.axis line {
		  fill: none;
		  stroke: #000;
		  shape-rendering: crispEdges;
		}

		.x.axis path {
		  display: none;
		}

		.bubbleChart svg
		{
			min-width:800px
		}
	</style>
</head>
<body>
<?php
		parse_str($_SERVER["QUERY_STRING"], $query_array);
		ini_set('max_execution_time', 3000000);
?>
<section class="featured" style="padding:80px 0 40px">
		<div class="container"> 
			<div class="row mar-bot40">
				<div class="col-md-6 col-md-offset-3">	
					<div class="align-center">
						<h2 class="slogan">Statistical Review</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="section-services" class="section pad-bot30 bg-white">
		<div class="container"> 
			<h4>What will you see:</h4>
			<ol>
				<li>Daily peak chart</li>
				<li>Average buzz chart</li>
				<li>Most frequent words</li>
				<li>Top mentioned account chart</li>
				<li>Top influencer chart</li>
				<li>Top hashtag chart</li>
			</ol>
		</div>
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<h4>How to use</h4>
			<p>Just tell us the topic you want to visualize i.e <code>ahok</code>. Note : Uppercase and lowercase doesn't matter.</p>
		</div>

		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>
		<div class="container">
			<div class="row">&nbsp;</div>
			<h4>Choosing the Topic</h4>
			<p>We stored some topics in our database, so select one of them to be loaded.</p>
				<form method="GET" action="visual.php?">
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
				<input type="submit" id="gen" class="btn btn-primary pull-right" style="margin-right:1%" value="I'm ready" />
			</div>
		</form>	
		<div class="row">&nbsp;</div>
		<div class="row">&nbsp;</div>

	<?php
					
		if(isset($query_array['tracker']))
		{
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
			
			$get_config = "SELECT * FROM cleanse_config WHERE tracker='".$query_array['tracker']."'";
			$res_get_conf = mysql_query($get_config);
			$res_conf = mysql_fetch_array($res_get_conf);

			$sql_count_all = "SELECT count(*) as semua from tweets WHERE tracker='".$query_array['tracker']."'";
			$sql_count = "SELECT count(*) as semua from tweets ";					
			$sql = "SELECT created_at, COUNT(*) as cnt from tweets ";
					
			$sql_wc = "SELECT text FROM tweets ";
					
			$sql_ti = "SELECT screen_name, COUNT(*) as cnt FROM tweets ";

			$flagWhere = 0;
					
			if(isset($res_conf['query']) && strlen($res_conf['query']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql .= " WHERE ";
					$sql_wc .= " WHERE ";
					$sql_ti .= " WHERE ";
					$sql_count .= " WHERE ";
					$flagWhere = 1;
				}
				
				$arr_spl = explode(",", $res_conf['query']);
				for($p = 0; $p < count($arr_spl); $p++)
				{
					if($p > 0)
					{
						$sql .= " AND ";
						$sql_wc .= " AND ";
						$sql_ti .= " AND ";
						$sql_count .= " AND ";
					}
					$sql .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_wc .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_ti .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_count .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
				}
			}
						
			if(isset($res_conf['source']) && strlen($res_conf['source']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql .= " WHERE ";
					$sql_wc .= " WHERE ";
					$sql_count .= " WHERE ";
					$sql_ti .= " WHERE ";
					$flagWhere = 1;
				}
				
				$arr_spl = explode(",", $res_conf['source']);
				for($p = 0; $p < count($arr_spl); $p++)
				{
					if(isset($res_conf['query']) && strlen($res_conf['query']) > 0 
						|| $p > 0)
					{
						$sql .= " AND ";
						$sql_wc .= " AND ";
						$sql_ti .= " AND ";
						$sql_count .= " AND ";
					}
					
					$sql .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_wc .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_ti .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_count .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
				}
			}
						
			if(isset($query_array['tracker']) && strlen($query_array['tracker']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql .= " WHERE ";
					$sql_count .= " WHERE ";
					$sql_wc .= " WHERE ";
					$sql_ti .= " WHERE ";
					$flagWhere = 1;
				}
				
				if(isset($res_conf['source']) && strlen($res_conf['source']) > 0 
					|| isset($res_conf['query']) && strlen($res_conf['query']) > 0)
					{
						$sql .= " AND ";
						$sql_wc .= " AND ";
						$sql_ti .= " AND ";
						$sql_count .= " AND ";
					}
				
				$sql .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_wc .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_ti .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_count .= " tracker = '".trim($query_array['tracker'])."'";
			}
			
			$sql .= " GROUP BY created_at";
			$sql_ti .= " GROUP BY screen_name
					ORDER BY cnt DESC";
			#$sql_dw = $sql;
			
			#$sql .= " limit ".(($curr_page-1)*100).",100";
			//echo 'Easy it\'s not harmful, it\'s a debug mode (ask the programmer politely why this text is appearing): <br/> '.$sql;
			
			

			// Dailypeak
					
			#print($sql_ti);
			
			$res = mysql_query($sql);
			$res_count = mysql_query($sql_count);
			$res_count_all = mysql_query($sql_count_all);
			$assoc_res_count = mysql_fetch_array($res_count);
			$assoc_res_count_all = mysql_fetch_array($res_count_all);
			
			$res_wc = mysql_query($sql_wc);
			$res_ti = mysql_query($sql_ti);
			
					
			$f = fopen("data/data_viz/dailypeak.json", "w");
			$g = fopen("data/data_viz/averagebuzz.json", "w");
			$data = array();
			$data_g = array();
			$data_word = array();
			$data_word_men = array();
			$data_word_hash = array();
			$enum_month = array(30,28,31,30,31,30,31,31,30,31,30,31);
			while($row = mysql_fetch_array($res))
			{
				array_push($data, array("date" => substr($row['created_at'],0, 10), "value"=>intval($row['cnt'])));
				array_push($data_g, array("date" => substr($row['created_at'],0, 10), "value"=>(intval($row['cnt'])/intval(substr($row['created_at'], 9,2)))));
			}
			fwrite($f, json_encode($data));
			fclose($f);
			fwrite($g, json_encode($data_g));
			fclose($g);
			
			
			while($row = mysql_fetch_array($res_wc))
			{
				$exp=explode(" ", $row['text']);
				for($p = 0; $p < count($exp); $p++)
				{
					if(substr($exp[$p],0,1) == "@")
					{
						array_push($data_word_men, $exp[$p]);
					}if(substr($exp[$p],0,1) == "#")
					{
						array_push($data_word_hash, $exp[$p]);
					}
					array_push($data_word, $exp[$p]);
				}
			}
			
			$data_word = array_count_values($data_word);
			$data_word_men = array_count_values($data_word_men);
			$data_word_hash = array_count_values($data_word_hash);
			$sor = $data_word;
			$sor_men = $data_word_men;
			$sor_hash = $data_word_hash;
			
			arsort($sor);
			arsort($sor_men);
			arsort($sor_hash);
			
			// end of dailypeak
			
			$f = fopen("data/data_viz/topmention.tsv", "w");
			fwrite($f, "letter\tfrequency\n");
			$count = 0;
			foreach($sor_men as $x => $x_value) {
				if($count == 15)break;
				fwrite($f, $x."\t".$x_value."\n");
				$count++;
			}
			
			$f = fopen("data/data_viz/tophashtag.tsv", "w");
			fwrite($f, "letter\tfrequency\n");
			$count = 0;
			foreach($sor_hash as $x => $x_value) {
				if($count == 15)break;
				fwrite($f, $x."\t".$x_value."\n");
				$count++;
			}
			
			$f = fopen("data/data_viz/topinfluencer.tsv", "w");
			fwrite($f, "letter\tfrequency\n");
			$count = 0;
			while($row = mysql_fetch_array($res_ti))
			{
				if($count == 15)break;
				fwrite($f, $row['screen_name']."\t".$row['1']."\n");
				$count++;
			}
			fclose($f);
			mysql_close($dbhandle);
			
		}
	?>
	
	<div class="container-fluid">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#dp">Daily Peak</a></li>
		  <li><a data-toggle="tab" href="#ab">Average Buzz</a></li>
		  <li><a data-toggle="tab" href="#mfw">Most Freq Words</a></li>
		  <li><a data-toggle="tab" href="#tm">Top Mention</a></li>
		  <li><a data-toggle="tab" href="#th">Top Hashtag</a></li>
		  <li><a data-toggle="tab" href="#ti">Top Influencer</a></li>
		  <li><a data-toggle="tab" href="#misc">Miscellaneous</a></li>
		</ul>

		<div class="tab-content">
		  <div id="dp" class="tab-pane fade in active">
			<center><h3>Daily Peak</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12" style="display:inline">
				<div class="col-lg-12">
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>

				</div>
				<div class="row col-lg-12 text-center" >
					<div id="dailypeak"></div>
				</div>
			</div>
		  </div>
		  <div id="ab" class="tab-pane fade">
			<center><h3>Average Buzz</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12"  >
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>

			</div>
			<div class="row col-lg- text-center" >
					<div id="averagebuzz"></div>
				</div>
		  </div>
		  <div id="mfw" class="tab-pane fade">
			<center><h3>Most Frequent Word</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12" style="display:inline">
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>

			</div>
			<div class="row col-lg-12 text-center" >
					<div class="bubbleChart"></div>
				</div>
		</div>
		<div id="tm" class="tab-pane fade">
			<center><h3>Top Mention</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12">
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>

			</div>


			<div class="row col-lg-12 text-center">
					<div class="topmention"></div>
			</div>
		</div>
		<div id="th" class="tab-pane fade">
			<center><h3>Top Hashtag</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12">
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>
			</div>
			<div class="col-lg-12 text-center" >
				<div class="tophashtag"></div>
			</div>
		</div>
		<div id="ti" class="tab-pane fade">
			<center><h3>Top Influencer</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12" >
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>
			</div>
			<div class="col-lg-12 text-center" >
				<div class="topinfluencer"></div>
			</div>
		</div>
		<div id="misc" class="tab-pane fade">
			<center><h3>Miscellaneous</h3></center>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12" >
				<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

				<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

				<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>
			</div>
			<div class="col-lg-12 text-center" >
				<div class="misc">
					<svg viewBox="200 0 1560 1100" width="960" height="800">
						<g class="legend" transform="translate(910,580)"><g>
						<circle cy="-25.980762113533157" r="550"></circle>
						<text y="35.961524" x="-100" dy="1.3em">
							<?php
								echo $query_array['tracker']." after cleansing ".$assoc_res_count['semua']." tweets";

							?>
						</text>
						</g><g>
						<circle cy="74.742346" r="450"></circle>
						<text y="-602.484692" x="-90" dy="7.3em">
							<?php
								echo "All ".$query_array['tracker']." ".$assoc_res_count_all['semua']." tweets";
							?>
						</text>
						</g></g>
					</svg>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	// Daily peak
	d3.json('data/data_viz/dailypeak.json', function(data) {
    data = MG.convert.date(data, 'date');
		MG.data_graphic({
			title: "Daily Peak",
			description: "The daily peak.",
			data: data,
			width: 900,
			height: 400,
			right: 40,
			target: document.getElementById('dailypeak'),
			x_accessor: 'date',
			y_accessor: 'value'
		});
	});
	
	d3.json('data/data_viz/averagebuzz.json', function(data) {
    data = MG.convert.date(data, 'date');
		MG.data_graphic({
			title: "Average Buzz",
			description: "The Average Buzz",
			data: data,
			width: 900,
			height: 400,
			right: 40,
			target: document.getElementById('averagebuzz'),
			x_accessor: 'date',
			y_accessor: 'value'
		});
	});
	
	 var bubbleChart = new d3.svg.BubbleChart({
    supportResponsive: true,
    //container: => use @default
    size: 800,
    //viewBoxSize: => use @default
    innerRadius: 600 / 3.5,
    //outerRadius: => use @default
    radiusMin: 50,
    //radiusMax: use @default
    //intersectDelta: use @default
    //intersectInc: use @default
    //circleColor: use @default
    data: {
      items: [
			<?php
			$count = 0;
			foreach($sor as $x => $x_value) {
				if($count == 20)break;
				 echo "{\"text\":\"". $x ."\",\"count\":" . $x_value."}";
				if($count < 19)
				{
					echo ",";
				}
				$count++;
			}
			?>

      ],
      eval: function (item) {return item.count;},
      classed: function (item) {return item.text;}
    },
    plugins: [
      {
        name: "central-click",
        options: {
          text: "(See more detail)",
          style: {
            "font-size": "12px",
            "font-style": "italic",
            "font-family": "Source Sans Pro, sans-serif",
            //"font-weight": "700",
            "text-anchor": "middle",
            "fill": "white"
          },
          attr: {dy: "65px"},
          centralClick: function() {
            alert("Here is more details!!");
          }
        }
      },
      {
        name: "lines",
        options: {
          format: [
            {// Line #0
              textField: "count",
              classed: {count: true},
              style: {
                "font-size": "16px",
                "font-family": "Source Sans Pro, sans-serif",
                "text-anchor": "middle",
                fill: "white"
              },
              attr: {
                dy: "0px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            },
            {// Line #1
              textField: "text",
              classed: {text: true},
              style: {
                "font-size": "12px",
                "font-family": "Source Sans Pro, sans-serif",
                "text-anchor": "middle",
                fill: "white"
              },
              attr: {
                dy: "20px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            }
          ],
          centralFormat: [
            {// Line #0
              style: {"font-size": "24px"},
              attr: {}
            },
            {// Line #1
              style: {"font-size": "16px"},
              attr: {dy: "40px"}
            }
          ]
        }
      }]
  });
  

var margin = {top: 20, right: 20, bottom: 180, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .ticks(10, "");

var svg = d3.select(".topmention").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("data/data_viz/topmention.tsv", type, function(error, data) {
  if (error) throw error;

  x.domain(data.map(function(d) { return d.letter; }));
  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
	   .selectAll("text")  
            .style("text-anchor", "end")
            .style("font-size","14pt")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-65)" );

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Frequency");

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.letter); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.frequency); })
      .attr("height", function(d) { return height - y(d.frequency); });
});

function type(d) {
  d.frequency = +d.frequency;
  return d;
}

var svg_hash = d3.select(".tophashtag").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("data/data_viz/tophashtag.tsv", type, function(error, data) {
  if (error) throw error;

  x.domain(data.map(function(d) { return d.letter; }));
  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

  svg_hash.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
	  	   .selectAll("text")  
            .style("text-anchor", "end")
            .style("font-size","14pt")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-65)" );


  svg_hash.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      //.attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Frequency");

  svg_hash.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.letter); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.frequency); })
      .attr("height", function(d) { return height - y(d.frequency); });
});

function type(d) {
  d.frequency = +d.frequency;
  return d;
}

var svg_inf = d3.select(".topinfluencer").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + 200 + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("data/data_viz/topinfluencer.tsv", type, function(error, data) {
  if (error) throw error;

  x.domain(data.map(function(d) { return d.letter; }));
  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

  svg_inf.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
	  	   .selectAll("text")  
            .style("text-anchor", "end")
            .style("font-size","14pt")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", "rotate(-65)" );


  svg_inf.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      //.attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Frequency");

  svg_inf.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.letter); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.frequency); })
      .attr("height", function(d) { return height - y(d.frequency); });
});

function type(d) {
  d.frequency = +d.frequency;
  return d;
}
	// end of dailypeak
</script>
</html>