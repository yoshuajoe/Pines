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
	<link href="css/metricsgraphics.css" rel="stylesheet" type="text/css" />

  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/metricsgraphics.css" rel="stylesheet" type="text/css" />
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
</style>
</head>
<body>
	<?php
		parse_str($_SERVER["QUERY_STRING"], $query_array);
		ini_set('max_execution_time', 3000000);
					
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

			$sql_senti_pos = "SELECT created_at, COUNT(*) as cnt FROM tweets
					WHERE tracker='".$query_array['tracker']."'  AND polarity = 'positif' 
					GROUP BY created_at";
			$sql_senti_net = "SELECT created_at, COUNT(*) as cnt FROM tweets
					WHERE tracker='".$query_array['tracker']."'  AND polarity = 'netral' 
					GROUP BY created_at";
			$sql_senti_neg = "SELECT created_at, COUNT(*) as cnt FROM tweets
					WHERE tracker='".$query_array['tracker']."'  AND polarity = 'negatif' 
					GROUP BY created_at";
			
			$res_pos = mysql_query($sql_senti_pos);
			$res_net = mysql_query($sql_senti_net);
			$res_neg = mysql_query($sql_senti_neg);
			
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
			
			$f = fopen("data/data_viz/senti.csv", "w");
			fwrite($f, "label,count\n");
			fwrite($f, "positif,".$count_pos."\n");
			fwrite($f, "netral,".$count_net."\n");
			fwrite($f, "negatif,".$count_neg."\n");
			fclose($f);

			$arr_pol = array($arr_temp_1,$arr_temp_2,$arr_temp_3);
			
			$f = fopen("data/data_viz/polarity_viz.json", "w");
			fwrite($f, json_encode($arr_pol));
			fclose($f);
			
			// end of dailypeak
			mysql_close($dbhandle);
			
		}
	?>
	<div class="container-fluid">
		<div class="bs-callout bs-callout-info" id="callout-navbar-breakpoint">
			<h4>Sentiment Analysis</h4>
			<p>We appreciate your efforts so here is the dessert. Once again I'll ask you something below.</p>
			<form method="GET" action="senti.php?">
			<div class="input-group">
					<span class="input-group-btn">
						<h3>Which topic ..&nbsp;</h3>
					</span>
					<div class="row">&nbsp;</div>
					<input type="text" style="text-deoration:none;width:30%;padding:2%;font-size:16pt;color:gray;" name="tracker" class="form-control" 
					value="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; ?>">
			</div>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<input type="submit" class="btn btn-success" value="I'm ready ">
			</form>	
			<br/>
		</div>
	</div>
	<div class="container-fluid">
		<center><h1 style="font-size:24pt">Sentiment Portion</h1></center>
		<div id="chart"></div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	
	<div class="row">&nbsp;</div>
	
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	<div class="row">&nbsp;</div>
	
	
	<center><div class="container-fluid">
		<h3>Sentiment per Day</h3>
			<div class="row">&nbsp;</div>
			<div class="row">&nbsp;</div>
			<div class="row col-lg-12" style="display:inline;text-align:center">
				<div class="col-lg-6" style="text-align:center">
					<div id="polarity" style="text-align:center"></div>
				</div>
				<div class="row">
                <div class="col-lg-7 legend" style="text-align:center;">
                	<span class="mg-line1-legend-color">— Positif&nbsp; </span><span class="mg-line2-legend-color">— Netral&nbsp; </span><span class="mg-line3-legend-color">— Negatif&nbsp; </span>
                </div>
                <div class="col-lg-5"></div>
            </div>
			</div>
	</div></center>
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
	        description: "This line chart contains multiple lines.",
	        data: data,
	        width: $(window).width()-100,
	        height: 700,
	        right: 0,
	        target: '#polarity',
	        legend: ['Positif','Netral','Negatif'],
	        legend_target: '.legend'
	    });
	});
    </script>
</html>