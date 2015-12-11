<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
     <title>Twitter Analysis | Issue Mapping</title>
      <script type="text/javascript" src="jquery-1.11.3.js"></script>
      <script type="text/javascript" src="jquery.tabletojson.js"></script>
      <script type="text/javascript" src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/d3.min.js"></script>
      <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
         h1 {                                                            /* NEW */
         font-size: 14px;                                              /* NEW */
         text-align: center;                                           /* NEW */
         }  
      </style>
    <style>

  .node circle {
    fill: #fff;
    stroke: steelblue;
    stroke-width: 3px;
  }

  .node text { font: 12px sans-serif; }

  .link {
    fill: none;
    stroke: #ccc;
    stroke-width: 2px;
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
            <h2 class="slogan">Issue Mapping</h2>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="section-services" class="section pad-bot30 bg-white">
    <div class="container"> 
      <h4>What will you see:</h4>
      <ol>
        <li>A tree of words</li>
      </ol>
    </div>
    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="container">
      <h4>How to use</h4>
      <p>Just tell us the topic you want to visualize i.e <code>ahok</code> and tell us the depth of tree. Note : Uppercase and lowercase doesn't matter.</p>
    </div>

    <div class="row">&nbsp;</div>
    <div class="row">&nbsp;</div>
    <div class="container">
      <div class="row">&nbsp;</div>
      <h4>Choosing the Topic</h4>
      <p>We stored some topics in our database, so select one of them to be loaded.</p>
        <form method="GET" action="issue.php?">
      <div class="input-group">
        <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" style="background-color:#fff;color:#000" type="button">Which topics&nbsp;</button>
        </span>
        <input type="text" name="tracker" class="form-control"  placeholder="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; else echo "topics"; ?>" 
          value="<?php if(isset($query_array['tracker'])) echo $query_array['tracker']; ?>">
        </div>
      </div>
      <p>Please define the depth of tree</p>
      <div class="input-group">
        <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" style="background-color:#fff;color:#000" type="button">Depth of tree&nbsp;</button>
        </span>
        <input type="text" name="depth" class="form-control"  placeholder="<?php if(isset($query_array['depth'])) echo $query_array['depth']; else echo "depth"; ?>" 
          value="<?php if(isset($query_array['depth'])) echo $query_array['depth']; ?>">
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
          
          // Dailypeak
          $sql = "SELECT * FROM tweets
              WHERE tracker='".$query_array['tracker']."'";
          print($sql);
          $res = mysql_query($sql);
          
          $file = "data/data_viz/datas.json";
          if (!unlink($file))
          {
            echo ("Error deleting $file");
          }
          else
          {
            echo ("Deleted $file");
          }

          $f = fopen("data/data_viz/datas.json", "w");
          $arr = array(array());
          $p = 0;
          while ($row = mysql_fetch_array($res)) {
            $arr[$p] = array(
                    'text_clean' => $row['text_clean'],
                  );
            #print_r($arr[$p]);
            $p++;
          }
          fwrite($f, json_encode($arr));
          fclose($f);
         
          $command = 'C:/Users/Yoshua/Anaconda/python.exe c:/xampp/htdocs/experiment/fassoc.py -tracker='.$query_array['tracker'].' -depth='.$query_array['depth'].' > assoc.txt';
          #print($command);
          $output = exec($command);
         }
          
         ?>
      </div>
       <div class="container">
        <div class="row col-lg-12 text-center">
         <center>
            <h1 style="font-size:24pt">Issue Mapping</h1>
         </center>
         </div>
         <div id="chart"></div>
      </div>
  </section>
<!-- load the d3.js library --> 
<script src="http://d3js.org/d3.v3.min.js"></script>
  
<script>

// ************** Generate the tree diagram  *****************
      var margin = {top: 20, right: 120, bottom: 20, left: 120},
          width = $(window).width() + margin.right + margin.left,
          height = $(window).height() - margin.top - margin.bottom;
      
      var i = 0,
          duration = 750,
          root;
      
      var tree = d3.layout.tree()
          .size([height, width]);
      
      var diagonal = d3.svg.diagonal()
          .projection(function(d) { return [d.y, d.x]; });
      
      var svg = d3.select("#chart").append("svg")
          .attr("width", width + margin.right + margin.left)
          .attr("height", height + margin.top + margin.bottom)
        .append("g")
          .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
      
      d3.json("data/data_viz/flare.json", function(error, flare) {
        if (error) throw error;
      
        root = flare;
        root.x0 = height / 2;
        root.y0 = 0;
      
        function collapse(d) {
          if (d.children) {
            d._children = d.children;
            d._children.forEach(collapse);
            d.children = null;
          }
        }
      
        root.children.forEach(collapse);
        update(root);
      });
      
      d3.select(self.frameElement).style("height", "800px");
      
      function update(source) {
      
        // Compute the new tree layout.
        var nodes = tree.nodes(root).reverse(),
            links = tree.links(nodes);
      
        // Normalize for fixed-depth.
        nodes.forEach(function(d) { d.y = d.depth * 80; });
      
        // Update the nodes…
        var node = svg.selectAll("g.node")
            .data(nodes, function(d) { return d.id || (d.id = ++i); });
      
        // Enter any new nodes at the parent's previous position.
        var nodeEnter = node.enter().append("g")
            .attr("class", "node")
            .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
            .on("click", click);
      
        nodeEnter.append("circle")
            .attr("r", 1e-6)
            .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
      
        nodeEnter.append("text")
            .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
            .attr("dy", ".35em")
            .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
            .text(function(d) { return d.name; })
            .style("fill-opacity", 1e-6);
      
        // Transition nodes to their new position.
        var nodeUpdate = node.transition()
            .duration(duration)
            .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
      
        nodeUpdate.select("circle")
            .attr("r", 4.5)
            .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
      
        nodeUpdate.select("text")
            .style("fill-opacity", 1);
      
        // Transition exiting nodes to the parent's new position.
        var nodeExit = node.exit().transition()
            .duration(duration)
            .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
            .remove();
      
        nodeExit.select("circle")
            .attr("r", 1e-6);
      
        nodeExit.select("text")
            .style("fill-opacity", 1e-6);
      
        // Update the links…
        var link = svg.selectAll("path.link")
            .data(links, function(d) { console.log(d);return d.target.id; });
      
        // Enter any new links at the parent's previous position.
        link.enter().insert("path", "g")
            .attr("class", "link")
            .attr("d", function(d) {
              var o = {x: source.x0, y: source.y0};
              return diagonal({source: o, target: o});
            });
      
        // Transition links to their new position.
        link.transition()
            .duration(duration)
            .attr("d", diagonal);
      
        // Transition exiting nodes to the parent's new position.
        link.exit().transition()
            .duration(duration)
            .attr("d", function(d) {
              var o = {x: source.x, y: source.y};
              return diagonal({source: o, target: o});
            })
            .remove();
      
        // Stash the old positions for transition.
        nodes.forEach(function(d) {
          d.x0 = d.x;
          d.y0 = d.y;
        });
      }
      
      // Toggle children on click.
      function click(d) {
        if (d.children) {
          d._children = d.children;
          d.children = null;
        } else {
          d.children = d._children;
          d._children = null;
        }
        update(d);
      }
         


</script>
  
  </body>
</html>