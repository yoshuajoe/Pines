<html>  
<head>    
    <title>Twitter Analysis | Visualization</title>
    <script type="text/javascript" src="jquery-1.11.3.js"></script>
	<script type="text/javascript" src="js/d3.min.js"></script>
	<script type="text/javascript" src="js/metricsgraphics.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>


  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/metricsgraphics.css" rel="stylesheet" type="text/css" />

  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/metricsgraphics.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<style>
		.fa
		{
			margin-top:3px;
			color: #fff;
		}
		.nav li
		{
			height: 4%;
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

		svg g text, tspan
		{
			 font-size:2rem !important;
		}
		.mg-x-axis>text
		{
			display: none !important;
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

    #chart {
        height: 360px;
        margin: 0 auto;                                               /* NEW */
        position: relative;
        width: 500px;
      }
      .tooltip {
        background: #eee;
        box-shadow: 0 0 5px #999999;
        color: #333;
        display: none;
        font-size: 12px;
        left: 130px;
        padding: 10px;
        position: absolute;
        text-align: center;
        top: 95px;
        width: 80px;
        z-index: 10;
      }
      .legend {
        font-size: 12px;
      }
      rect {
        cursor: pointer;                                              /* NEW */
        stroke-width: 2;
      }
      rect.disabled {                                                 /* NEW */
        fill: transparent !important;                                 /* NEW */
      }                                                               /* NEW */
      h1 {                                                            /* NEW */
        font-size: 14px;                                              /* NEW */
        text-align: center;                                           /* NEW */
      } 

     .nav-tabs
     {
     	border-bottom: none;
     } 
     .timeline {
    list-style: none;
    padding: 20px 0 20px;
    position: relative;
}

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li > .timeline-panel {
            width: 46%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

            .timeline > li > .timeline-panel:before {
                position: absolute;
                top: 26px;
                right: -15px;
                display: inline-block;
                border-top: 15px solid transparent;
                border-left: 15px solid #ccc;
                border-right: 0 solid #ccc;
                border-bottom: 15px solid transparent;
                content: " ";
            }

            .timeline > li > .timeline-panel:after {
                position: absolute;
                top: 27px;
                right: -14px;
                display: inline-block;
                border-top: 14px solid transparent;
                border-left: 14px solid #fff;
                border-right: 0 solid #fff;
                border-bottom: 14px solid transparent;
                content: " ";
            }

        .timeline > li > .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 50%;
            margin-left: -25px;
            background-color: #999999;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }

        .timeline > li.timeline-inverted > .timeline-panel {
            float: right;
        }

            .timeline > li.timeline-inverted > .timeline-panel:before {
                border-left-width: 0;
                border-right-width: 15px;
                left: -15px;
                right: auto;
            }

            .timeline > li.timeline-inverted > .timeline-panel:after {
                border-left-width: 0;
                border-right-width: 14px;
                left: -14px;
                right: auto;
            }

.timeline-badge.primary {
    background-color: #2e6da4 !important;
}

.timeline-badge.success {
    background-color: #3f903f !important;
}

.timeline-badge.warning {
    background-color: #f0ad4e !important;
}

.timeline-badge.danger {
    background-color: #d9534f !important;
}

.timeline-badge.info {
    background-color: #5bc0de !important;
}

.timeline-title {
    margin-top: 0;
    color: inherit;
}

.timeline-body > p,
.timeline-body > ul {
    margin-bottom: 0;
}

    .timeline-body > p + p {
        margin-top: 5px;
    }

@media (max-width: 767px) {
    ul.timeline:before {
        left: 40px;
    }

    ul.timeline > li > .timeline-panel {
        width: calc(100% - 90px);
        width: -moz-calc(100% - 90px);
        width: -webkit-calc(100% - 90px);
    }

    ul.timeline > li > .timeline-badge {
        left: 15px;
        margin-left: 0;
        top: 16px;
    }

    ul.timeline > li > .timeline-panel {
        float: right;
    }

        ul.timeline > li > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.timeline > li > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
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
						<h2 class="slogan">Sentiment Analysis</h2>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="section-services" class="section pad-bot30 bg-white">
    <div class="container"> 
      <h4>What will you see:</h4>
      <ol>
        <li>A chart of sentiment</li>
      </ol>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="container">
      <h4>How to use</h4>
      <p>Just tell us the topic you want to visualize i.e <code>ahok</code> and tell us the depth of tree. Note : Uppercase and lowercase doesn't matter.</p>
    </div>
	<div class="container">
      <div class="row">&nbsp;</div>
      <h4>Choosing the Topic</h4>
      <p>We stored some topics in our database, so select one of them to be loaded.</p>
      <form method="GET" action="senti.php?">
      <div class="input-group">
        <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" style="background-color:#fff;color:#000" type="button">Which topics&nbsp;</button>
        </span>
        <input type="text" name="tracker" class="form-control"  placeholder="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; else echo "topics"; ?>" 
          value="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; ?>">
        </div>
      </div>

        <input type="hidden" name="page" value="<?php if(isset($query_array['page'])) echo $query_array['page']; else echo 1;?>"/>          
        <input type="submit" id="gen" class="btn btn-primary pull-right" style="margin-right:1%" value="I'm ready" />
      </form>
	<?php				
		if(isset($query_array['tracker']))
		{
			$username = "root";
			$password = "";
			$hostname = "127.0.0.1"; 
		
			$dbhandle = mysql_connect($hostname, $username, $password) 
					 or die("Unable to connect to MySQL");
					//echo "Connected to MySQL<br>";

			$selected = mysql_select_db("datamining",$dbhandle) 
			or die("Could not select examples");

			$sql_senti_pos = "SELECT created_at, COUNT(*) as cnt FROM tweets";
			$sql_senti_net = "SELECT created_at, COUNT(*) as cnt FROM tweets";
			$sql_senti_neg = "SELECT created_at, COUNT(*) as cnt FROM tweets";

			$sql_di_pos = "SELECT *  FROM tweets";
			$sql_di_net = "SELECT * FROM tweets";
			$sql_di_neg = "SELECT * FROM tweets";

			$get_config = "SELECT * FROM cleanse_config WHERE tracker='".$query_array['tracker']."'";
			$res_get_conf = mysql_query($get_config);
			$res_conf = mysql_fetch_array($res_get_conf);
			$flagWhere = 0; 

			if(isset($res_conf['query']) && strlen($res_conf['query']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql_senti_pos .= " WHERE ";
					$sql_senti_net .= " WHERE ";
					$sql_senti_neg .= " WHERE ";
					$sql_di_pos .= " WHERE ";
					$sql_di_net .= " WHERE ";
					$sql_di_neg .= " WHERE ";
					$flagWhere = 1;
				}
				
				$arr_spl = explode(",", $res_conf['query']);
				for($p = 0; $p < count($arr_spl); $p++)
				{
					if($p > 0)
					{
						$sql_senti_pos .= " AND ";
						$sql_senti_net .= " AND ";
						$sql_senti_neg .= " AND ";
						$sql_di_pos .= " AND ";
						$sql_di_net .= " AND ";
						$sql_di_neg .= " AND ";
					}

					$sql_di_pos .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_di_net .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_di_neg .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_senti_pos .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_senti_net .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_senti_neg .= " text NOT LIKE ('%".trim($arr_spl[$p])."%')";
				}
			}
						
			if(isset($res_conf['source']) && strlen($res_conf['source']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql_senti_pos .= " WHERE ";
					$sql_senti_net .= " WHERE ";
					$sql_senti_neg .= " WHERE ";
					$sql_di_pos .= " WHERE ";
					$sql_di_net .= " WHERE ";
					$sql_di_neg .= " WHERE ";
					$flagWhere = 1;
				}
				
				$arr_spl = explode(",", $res_conf['source']);
				for($p = 0; $p < count($arr_spl); $p++)
				{
					if(isset($res_conf['query']) && strlen($res_conf['query']) > 0 
						|| $p > 0)
					{
						$sql_senti_pos .= " AND ";
						$sql_senti_net .= " AND ";
						$sql_senti_neg .= " AND ";
						$sql_di_pos .= " AND ";
						$sql_di_net .= " AND ";
						$sql_di_neg .= " AND ";
					}
					
					$sql_senti_pos .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_senti_net .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_senti_neg .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_di_pos .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_di_net .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					$sql_di_neg .= " source NOT LIKE ('%".trim($arr_spl[$p])."%')";
					
				}
			}
						
			if(isset($query_array['tracker']) && strlen($query_array['tracker']) > 0)
			{
				if($flagWhere == 0)
				{
					$sql_senti_pos .= " WHERE ";
					$sql_senti_net .= " WHERE ";
					$sql_senti_neg .= " WHERE ";
					$sql_di_pos .= " WHERE ";
					$sql_di_net .= " WHERE ";
					$sql_di_neg .= " WHERE ";
					$flagWhere = 1;
				}
				
				if(isset($res_conf['source']) && strlen($res_conf['source']) > 0 
					|| isset($res_conf['query']) && strlen($res_conf['query']) > 0)
					{
						$sql_senti_pos .= " AND ";
						$sql_senti_net .= " AND ";
						$sql_senti_neg .= " AND ";
						$sql_di_pos .= " AND ";
						$sql_di_net .= " AND ";
						$sql_di_neg .= " AND ";
					}
				
				$sql_senti_pos .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_senti_net .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_senti_neg .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_di_pos .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_di_net .= " tracker = '".trim($query_array['tracker'])."'";
				$sql_di_neg .= " tracker = '".trim($query_array['tracker'])."'";
			
			}
			
			$sql_senti_pos .= "   AND polarity = 'positif' GROUP BY created_at";
			$sql_senti_neg .= "   AND polarity = 'negatif' GROUP BY created_at";
			$sql_senti_net .= "   AND polarity = 'netral' GROUP BY created_at";
			
			$sql_di_pos .= " ORDER BY RAND() LIMIT 10";
			$sql_di_net .= " ORDER BY RAND() LIMIT 10";
			$sql_di_neg .= " ORDER BY RAND() LIMIT 10";

			$res_pos = mysql_query($sql_senti_pos);
			$res_net = mysql_query($sql_senti_net);
			$res_neg = mysql_query($sql_senti_neg);

			$res_pos_di = mysql_query($sql_di_pos);
			$res_net_di = mysql_query($sql_di_net);
			$res_neg_di = mysql_query($sql_di_neg);

			print($sql_senti_pos);
			$arr_pol = array();
			$p = 0;
			$arr_temp_1 = array();
			$count_pos = 0;
			$count_net = 0;
			$count_neg = 0;

			while($row = mysql_fetch_array($res_pos))
			{
				$count_pos += intval($row['cnt']);
				$arr_temp_1[$p] = array("date"=>substr($row['created_at'],0,10),"value"=>$row['cnt']);
				$p++;
			}
			
			$p = 0;
			$arr_temp_2 = array();
			while($row = mysql_fetch_array($res_net))
			{
				$count_net += intval($row['cnt']);
				$arr_temp_2[$p] = array("date"=>substr($row['created_at'],0,10),"value"=>$row['cnt']);
				$p++;
			}
			
			
			$p = 0;
			$arr_temp_3 = array();
			while($row = mysql_fetch_array($res_neg))
			{
				$count_neg += intval($row['cnt']);
				$arr_temp_3[$p] = array("date"=>substr($row['created_at'],0,10),"value"=>$row['cnt']);
				$p++;
			}
			
			
			// end of dailypeak
			mysql_close($dbhandle);
			
		}
	?>
	<div class="container">
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#ss">Sentiment Statistic</a></li>
		  <li><a data-toggle="tab" href="#spd">Sentiment Per Day</a></li>
		  <li><a data-toggle="tab" href="#di">Dive in</a></li>
		</ul>
		<div class="tab-content">
			<div id="ss" class="tab-pane fade in active">
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<center><h3>Sentiment Statistic</h3></center>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row col-lg-12" style="display:inline">
					<div class="col-lg-12">
						<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

						<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

						<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>
					</div>
					<div class="row col-lg-12 text-center" >
						<div id="senstat"></div>
					</div>
				</div>
			  </div>	
		 	 
			  <div id="spd" class="tab-pane fade in">
			  		<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<center><h3>Sentiment Per Day</h3></center>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row col-lg-12" style="display:inline">
					<div class="col-lg-12">
					<p>This slide is showing how many tweets were collected during the previous step We set the svg element’s size in JavaScript so that we can compute the height based on the size of the dataset (data.length). This way, the size is based on the height of each bar rather than the overall height of the chart, and we ensure adequate room for labels.</p>

					<p>Each bar consists of a g element which in turn contains a rect and a text. We use a data join (an enter selection) to create a g element for each data point. We then translate the g element vertically, creating a local origin for positioning the bar and its associated label.</p>

					<p>Since there is exactly one rect and one text element per g element, we can append these elements directly to the g, without needing additional data joins. Data joins are only needed when creating a variable number of children based on data; here we are appending just one child per parent. The appended rects and texts inherit data from their parent g element, and thus we can use data to compute the bar width and label position.</p>

					</div>
					<div class="row col-lg-12 text-center" >
						<div id="polarity"></div>
					</div>
					<div class="row text-center">
            			<div class="col-lg-7 legend">
            				<span class="mg-line1-legend-color">— Positif&nbsp; </span><span class="mg-line2-legend-color">— Netral&nbsp; </span><span class="mg-line3-legend-color">— Negatif&nbsp; </span>
            			</div>
        			</div>
				</div>
			</div>
			<div id="di" class="tab-pane fade in">
			  		<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<center><h3>Dive Into Tweets</h3></center>
				<a href="issue?tracker='<?php echo $query_array['tracker']; ?>'" class="pull-right"><i class="fa fa-random" style="color:#337ab7"></i>&nbsp;Shuffle</a>
				<div class="row">&nbsp;</div>
				<div class="row">&nbsp;</div>
				<div class="row col-lg-12">
					<ul class="timeline">
			        <?php
			        	$i = 1;
			        	while($row=mysql_fetch_array($res_pos_di))
			        	{
			        		if($i%2 != 0)
			        		{
			        ?>
			        		<li>
					          <div class="timeline-badge <?php 
						          		if($row['polarity'] == "positif")
						          			echo "success";
						          		else if($row['polarity'] == "negatif")
						          			echo "danger";
						          		else
						          			echo "warning";
						          ?>"><i class="fa <?php 
						          		if($row['polarity'] == "positif")
						          			echo "fa-smile-o";
						          		else if($row['polarity'] == "negatif")
						          			echo "fa-frown-o";
						          		else
						          			echo "fa-meh-o";
						          ?> fa-2x">
						          </i></div>
					          <div class="timeline-panel">
					            <div class="timeline-heading">
					              <h4 class="timeline-title">@<?php echo $row{'screen_name'};?></h4>
					              <p><small class="text-muted"><i class="fa "></i> <?php echo substr($row{'created_at'},0,11);?> via <?php echo $row{'source'};?></small></p>
					            </div>
					            <div class="timeline-body">
					              <p><?php echo $row{'text'};?></p>
					            </div>
					          </div>
					        </li>
			        <?php
			        		}else
			        		{
			        ?>
				        	<li class="timeline-inverted">
						          <div class="timeline-badge <?php 
						          		if($row['polarity'] == "positif")
						          			echo "success";
						          		else if($row['polarity'] == "negatif")
						          			echo "danger";
						          		else
						          			echo "warning";
						          ?>"><i class="fa <?php 
						          		if($row['polarity'] == "positif")
						          			echo "fa-smile-o";
						          		else if($row['polarity'] == "negatif")
						          			echo "fa-frown-o";
						          		else
						          			echo "fa-meh-o";
						          ?> fa-2x"></i></div>
						          <div class="timeline-panel">
						            <div class="timeline-heading">
						              <h4 class="timeline-title">@<?php echo $row{'screen_name'};?></h4>
						              <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo substr($row{'created_at'},0,11);?> via <?php echo $row{'source'};?></small></p>
						            </div>
						            <div class="timeline-body">
						              <p><?php echo $row{'text'};?></p>
						            </div>
						          </div>
						        </li>
			        <?php
			        		}
			        		$i++;
			        	}
			        ?>
			        </ul>
				</div>
			</div>
	</div>

    </section>
	<script>
      (function(d3) {
        'use strict';

        var width = 500;
        var height = 700;
        var radius = Math.min(width, height) / 2;
        var donutWidth = 75;
        var legendRectSize = 18;
        var legendSpacing = 4;

        var color = d3.scale.ordinal().range(["steelblue", "#F4FA58", "#FE2E2E"]);


        var svg = d3.select('#chart')
          .append('svg')
          .attr('width', width)
          .attr('height', height)
          .append('g')
          .attr('transform', 'translate(' + (width / 2) + 
            ',' + (height / 2) + ')');

        var arc = d3.svg.arc()
          .innerRadius(radius - donutWidth)
          .outerRadius(radius);

        var pie = d3.layout.pie()
          .value(function(d) { return d.count; })
          .sort(null);

        var tooltip = d3.select('#chart')
          .append('div')
          .attr('class', 'tooltip');
        
        tooltip.append('div')
          .attr('class', 'label');

        tooltip.append('div')
          .attr('class', 'count');

        tooltip.append('div')
          .attr('class', 'percent');

        d3.csv('data/data_viz/senti.csv', function(error, dataset) {
          dataset.forEach(function(d) {
            d.count = +d.count;
            d.enabled = true;                                         // NEW
          });

          var path = svg.selectAll('path')
            .data(pie(dataset))
            .enter()
            .append('path')
            .attr('d', arc)
            .attr('fill', function(d, i) { 
              return color(d.data.label); 
            })                                                        // UPDATED (removed semicolon)
            .each(function(d) { this._current = d; });                // NEW

          path.on('mouseover', function(d) {
            var total = d3.sum(dataset.map(function(d) {
              return (d.enabled) ? d.count : 0;                       // UPDATED
            }));
            var percent = Math.round(1000 * d.data.count / total) / 10;
            tooltip.select('.label').html(d.data.label);
            tooltip.select('.count').html(d.data.count); 
            tooltip.select('.percent').html(percent + '%'); 
            tooltip.style('display', 'block');
          });
          
          path.on('mouseout', function() {
            tooltip.style('display', 'none');
          });

          /* OPTIONAL 
          path.on('mousemove', function(d) {
            tooltip.style('top', (d3.event.pageY + 10) + 'px')
              .style('left', (d3.event.pageX + 10) + 'px');
          });
          */
            
          var legend = svg.selectAll('.legend')
            .data(color.domain())
            .enter()
            .append('g')
            .attr('class', 'legend')
            .attr('transform', function(d, i) {
              var height = legendRectSize + legendSpacing;
              var offset =  height * color.domain().length / 2;
              var horz = -2 * legendRectSize;
              var vert = i * height - offset;
              return 'translate(' + horz + ',' + vert + ')';
            });

          legend.append('rect')
            .attr('width', legendRectSize)
            .attr('height', legendRectSize)                                   
            .style('fill', color)
            .style('stroke', color)                                   // UPDATED (removed semicolon)
            .on('click', function(label) {                            // NEW
              var rect = d3.select(this);                             // NEW
              var enabled = true;                                     // NEW
              var totalEnabled = d3.sum(dataset.map(function(d) {     // NEW
                return (d.enabled) ? 1 : 0;                           // NEW
              }));                                                    // NEW
              
              if (rect.attr('class') === 'disabled') {                // NEW
                rect.attr('class', '');                               // NEW
              } else {                                                // NEW
                if (totalEnabled < 2) return;                         // NEW
                rect.attr('class', 'disabled');                       // NEW
                enabled = false;                                      // NEW
              }                                                       // NEW

              pie.value(function(d) {                                 // NEW
                if (d.label === label) d.enabled = enabled;           // NEW
                return (d.enabled) ? d.count : 0;                     // NEW
              });                                                     // NEW

              path = path.data(pie(dataset));                         // NEW

              path.transition()                                       // NEW
                .duration(750)                                        // NEW
                .attrTween('d', function(d) {                         // NEW
                  var interpolate = d3.interpolate(this._current, d); // NEW
                  this._current = interpolate(0);                     // NEW
                  return function(t) {                                // NEW
                    return arc(interpolate(t));                       // NEW
                  };                                                  // NEW
                });                                                   // NEW
            });                                                       // NEW
            
          legend.append('text')
            .attr('x', legendRectSize + legendSpacing)
            .attr('y', legendRectSize - legendSpacing)
            .text(function(d) { return d; });

        });

      })(window.d3);

    d3.json('data/data_viz/polarity_viz.json', function(data) {
	    for (var i = 0; i < data.length; i++) {
	        data[i] = MG.convert.date(data[i], 'date');
	    }

	    MG.data_graphic({
	        title: "Sentiment Analysis by Date",
	        description: "Sentiment by Date",
	        data: data,
	        width: $(window).width()-500,
	        height: 400,
	        right: 250,
	        target: '#polarity',
	        x_accessor: 'date',
	        legend: ['Positif','Netral','Negatif'],
	        legend_target: '.legend'
	    });
	});

	var bar_data = Array();
	bar_data[0] = {'label':'positif', 'value':<?php echo $count_pos; ?>};
	bar_data[1] = {'label':'negatif', 'value':<?php echo $count_neg; ?>};
	bar_data[2] = {'label':'netral', 'value':<?php echo $count_net; ?>};
	
	MG.data_graphic({
	    title: "Sentiment Summary",
	    description: "Work-in-progress",
	    data: bar_data,
	    chart_type: 'bar',
	    x_accessor: 'value',
	    y_accessor: 'label',
	    width: 600,
	    right: 0,
	    target: '#senstat',
	    animate_on_load: true,
	    x_axis: false
	});

    </script>
</html>