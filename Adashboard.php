<?php
	session_start();
	//var_dump($_SERVER['HTTP_REFERER']);
	$mRootpath = "";
	$mFilepath = explode('/',dirname(__DIR__));
	foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
	}
	define('ROOT_PATH', $mRootpath);

	include ROOT_PATH.'/public_html/base.php';

	function populateEvent(){
		$sql = "SELECT * FROM EVENT";
		$result = mysql_query($sql);
		var_dump($result);
		echo"<p>
			trying to populate events
		</p>";
		while($row = mysql_fetch_array($result)){
			echo "<option>".$row['NAME']."</option>";
		}
	}

	function populateAdmin() {
		$quer = "SELECT * FROM USERS";
		$res = mysql_query($quer);
		var_dump($res);
		echo"<p>
			trying to populate admins
		</p>";
		while($row = mysql_fetch_array($res)){
			var_dump($row['ADMIN']);
			if($row['ADMIN'] == '0'){
				echo "<option>".$row['USERNAME']."</option>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <!--<link rel="stylesheet" href="cgi-bin/css/main.css">-->
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="sylesheet" href = "cgi-bin/css/main.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
		<style>
			body {
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

			.line {
			  fill: none;
			  stroke: steelblue;
			  stroke-width: 1.5px;
			}
			.hide {
				display:none;
			}
		</style>
		<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TicketMiner</a>
      </div>
			<div class="navbar navbar-left">
				<a class="btn btn-primary " href="kill.php" style="!text-decoration: none;">Log Out</a>
			</div>
		</div>
    </nav>
    <div class="container">
      <div class="row">
        <h3 class="col-md-offset-1">Select an Event: </h3>
					<select class="form-control">
	          <option disabled selected>
	            Events
	          </option>
	          <?php
	            populateEvent();
	          ?>
	        </select>
			</div>
		</div>
			<br />
			<script>
				$(document).ready(function (){
					$('#adminEditMenu').hide();
					$('#DeleteMenu').hide();
					$('#adminEdit').click(function (){
						$('#DeleteMenu').hide();
						$('#adminEditMenu').toggle("slide");
					});
					$('#userDel').click(function (){
						$('#adminEditMenu').hide();
						$('#DeleteMenu').toggle("slide");
					});
				});
			</script>
			<div class="container">
				<div class="row">
					<a class="btn btn-primary" href="ticketAdder.php" style="!text-decoration: none;">Add Ticket</a>
					<button class="btn btn-primary" style="!text-decoration: none;">Event Data</button>
								<a class='btn btn-primary' href='priceAdder.php'style='!text-decoration: none;'>Add Price</a>
								<a class='btn btn-primary' href='eventAdder.php' style='text-decoration: none;'>Add Event</a>
											<button class='btn btn-primary' id='adminEdit'>Edit Admins</button>
											<button class='btn btn-primary' id='userDel'>Delete User</button>
								</div>
								<br />
							<div class='container' class="hide" id='adminEditMenu'>
								<div class='row'>
								<form class='form-horizontal' method='post' action='_updateUser.php'>
									<div class='form-group'>
										<div class='well' id='well2' style='overflow: auto;'>
												<select class='form-control'>
													<option disabled selected name='username'>
														Users
													</option>
														<?php
														populateAdmin();
														?>
												</select>
										</div>
									</div>
										<input class='btn btn-primary' type='submit' value= 'Submit Changes'>
								</form>
							</div>
						</div>
						<div class='container' class="hide" id='DeleteMenu'>
							<div class='row'>
							<form class='form-horizontal' method='post' action='_deleteUser.php'>
								<div class='form-group'>
									<div class='well' id='well2' style='overflow: auto;'>
											<select class='form-control'>
												<option disabled selected name='username'>
													Users
												</option>
												<?php
													populateAdmin();
												?>
											</select>
									</div>
									<input class='btn btn-primary' type='submit' value= 'Delete User'>
								</div>
							</form>
						</div>
					</div>
	    </div>
		<div>
			<div>
			</div>
		</div>
				<script src="//d3js.org/d3.v3.min.js"></script>
				<script>

				var margin = {top: 20, right: 20, bottom: 30, left: 50},
				    width = 960 - margin.left - margin.right,
				    height = 500 - margin.top - margin.bottom;

				var parseDate = d3.time.format("%d-%b-%y").parse;

				var x = d3.time.scale()
				    .range([0, width]);

				var y = d3.scale.linear()
				    .range([height, 0]);

				var xAxis = d3.svg.axis()
				    .scale(x)
				    .orient("bottom");

				var yAxis = d3.svg.axis()
				    .scale(y)
				    .orient("left");

				var line = d3.svg.line()
				    .x(function(d) { return x(d.DATE); })
				    .y(function(d) { return y(d.PRICE); });

				var svg = d3.select("body").append("svg")
						.attr("class", "col-md-offset-2")
				    .attr("width", width + margin.left + margin.right)
				    .attr("height", height + margin.top + margin.bottom)
				  .append("g")
				    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				d3.csv("PRICEDATA.csv", function(error, data) {
				  if (error) throw error;

				  data.forEach(function(d) {
				    d.DATE = parseDate(d.DATE);
				    d.PRICE = +d.PRICE;
						console.log(d.PRICE);
						console.log(d.DATE);
				  });

				  x.domain(d3.extent(data, function(d) { return d.DATE; }));
				  y.domain(d3.extent(data, function(d) { return d.PRICE; }));

				  svg.append("g")
				      .attr("class", "x axis")
				      .attr("transform", "translate(0," + height + ")")
				      .call(xAxis);

				  svg.append("g")
				      .attr("class", "y axis")
				      .call(yAxis)
				    .append("text")
				      .attr("transform", "rotate(-90)")
				      .attr("y", 6)
				      .attr("dy", ".71em")
				      .style("text-anchor", "end")
				      .text("Price ($)");

				  svg.append("path")
				      .datum(data)
				      .attr("class", "line")
				      .attr("d", line);
				});

				</script>
			</div>
		</div>
  </body>
  <!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="cgi-bin/js/main.js"></script>
	<script src='cgi-bin/js/graph.js'></script>
  <!-- jquery -->
</html>
