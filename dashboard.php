<?php
session_start();
//var_dump($_SERVER['HTTP_REFERER']);
$mRootpath = "";
$mFilepath = explode('/',dirname(__DIR__));
foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
}
define('ROOT_PATH', $mRootpath);

include ROOT_PATH.'public_html/base.php';

var_dump($_POST);



if($_POST["firstName"] == null || $_POST["lastName"] == null || $_POST["username"] == null || $_POST["password"] == null || $_POST["inputEmail"] == null){
}
else{
	$firstname  = ($_POST["firstName"]);
	$lastname   = ($_POST["lastName"]);
	$username   = ($_POST["username"]);
	$password   = ($_POST["password"]);
	$email      = ($_POST["inputEmail"]);
	if($_POST["admin"] == "on"){
		$admin = true;
	}
	else{
		$admin = false;
	}
/*
	//form validatin arrays
	$action = array();
	$action['result'] = null;

	$text = array();

	//make sure user fills out all forms, probably where form validation can go
	if(empty($username)){
		$action['result']= 'error';
		array_push($text, 'please enter a username');
		}
	if(empty($password)){
		$action['result']= 'error';
		array_push($text, 'please enter a password');
	}
	if(empty($email)){
		$action['result']= 'error';
		array_push($text, 'please enter an email');
	}
	if(empty($firstname)){
		$action['result']= 'error';
		array_push($text, 'please enter a first name');
	}
	if(empty($lastname)){
		$action['result']= 'error';
		array_push($text, 'please enter a last name');
	}
	if($action['result'] != 'error'){
		//this is where we can add encryption $password = md5($password)
	}
*/

//thinking problem may be with databse connection
  $add = mysql_query("INSERT INTO USERS VALUES('".$firstname."', '".$lastname."', '".$username."', '".$email."', '".$password."', '".$admin."')");
	var_dump($add);
	if($add){
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		echo "<p>inserted data</p>";
		$variables = [$firstname,
									$lastname,
									$username,
									$password,
									$email,
									$admin];
		var_dump($variables);
	}
	else {
		echo "<p>
			failed to insert
		</p>";
		var_dump($text);
		$variables = [$firstname,
									$lastname,
									$username,
									$password,
									$email,
									$admin];
		var_dump($variables);
	}
	//need to show errors at some point....
}


$mIsValidUser = false;
if($_POST["username"]!= null && $_POST["password"]!= null){

	//If there is a unsername varible in the post array then put it into the session
	//array.
	if(isset($_POST["username"])){
		$_SESSION["username"] = $_POST["username"];
	}else{
		$_SESSION['username'] = "";
	}

	//If there is a unsername varible in the post array then put it into the session
	//array.
	if(isset($_POST['password'])){
		$_SESSION['password'] = $_POST['password'];
	}else{
		$_SESSION['password'] = "";
	}
}

//this may be only for the login page, not signup, must pass a variable that shows where you are originating from
//session_start(); <--- You need this if the session has not yet been started
$sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'";
// Check to see if the query fails
if(!mysql_query($sql, $database)){
	echo "<p>Query Failed!</p>";
}

$result = mysql_query($sql);
if($result && mysql_num_rows($result) == 0){
	// If there are no rows with this username and password combination then redirect the user
	header( 'Location: index.php' );
}

if($result){
	if(mysql_result($result, 0, "ADMIN")=="1")
	{
		$_SESSION['admin'] = true;
	}
	else{
		$_SESSION['admin'] = false;
	}
}

if($_POST["row"] == null || $_POST["section"] == null || $_POST["seat"] == null || $_POST["event"] == null){
	echo "<p>Not coming from seat adder!</p>";
}else{
  $sid = mysql_query("SELECT SID FROM RSEAT WHERE ROW = '".$_POST["row"]."' AND SECTION = '".$_POST["section"]."' AND SEATNO = '".$_POST["seat"]."' GROUP BY SID");
	$eid = mysql_query("SELECT EID FROM EVENT WHERE NAME = '".$_POST['event']."' GROUP BY EID");

	$insertTicket = "INSERT INTO TICKET (EID, SID) VALUES ('".$eid."','".$sid."')"; //insert query to get post variables from add ticket and activate the ticket
  $R1 = mysql_query($insertTicket);
	if(!$R1){
		echo "<p>
		 insert into ticket failed
		</p>";
	}
  $activateSeat = "INSERT INTO SEAT (SID) VALUES('".$sid."')";
  $R2 = mysql_query($activateSeat);
	if(!$R2){
		echo "<p>
		 insert into seat table failed
		</p>";
	}
}


//is there a better way to determine WHICH page the user is coming from?
if($_POST['name'] == null || $_POST['type'] == null || $_POST['date'] == null || $_POST['venue'] == null){
	//do something
	echo "<p>not coming from event adder!</p>";
}else{
	$VIDquer = "SELECT VID FROM VENUE WHERE NAME = ".$_POST['venue']." GROUP BY VID";
	$vid = mysql_query($VIDquer);
  $event = "INSERT INTO EVENT (NAME, TYPE, DATE, VID) VALUES ('".$_POST['name']."', '".$_POST['type']."', '".$_POST['date']."', '".$vid."')";
	$result = mysql_query($event);
	if(!$result){
		echo "<p>
		unsuccessful insertion of event
		</p>";
	}else {
		echo "<p>
		inserted event!
		</p>";
	}
}

function write_tabbed_file($filepath, $array, $save_keys=false){
    $content = '';

    reset($array);
    while(list($key, $val) = each($array)){

        // replace tabs in keys and values to [space]
        $key = str_replace("\t", " ", $key);
        $val = str_replace("\t", " ", $val);

        if ($save_keys){ $content .=  $key."\t"; }

        // create line:
        $content .= (is_array($val)) ? implode("\t", $val) : $val;
        $content .= "\n";
    }

    if (file_exists($filepath) && !is_writeable($filepath)){
        return false;
    }
    if ($fp = fopen($filepath, 'w+')){
        fwrite($fp, $content);
        fclose($fp);
    }
    else { return false; }
    return true;
}
//coming from price adder
if($_POST['ticket'] == null || $_POST['file'] == null) {
	//do something
	echo "<p>not coming from price adder!</p>";
}else{
	$tid = $_POST['ticket'];
	var_dump($tid);
	$file = fopen($_POST['file'], "r");
	while(! feof($file))
	{
		$price = (fgetcsv($file));
		$event = "INSERT INTO PRICE (TID, PRICE) VALUES ('".$tid."', '".$price[0]."')";
		$result = mysql_query($event);
	}
	$quer = "SELECT * FROM PRICE";
	$array = mysql_query($quer);
	var_dump($array);
	write_tabbed_file('prices.tsv', $array, $save_keys, true);
}


function populateEvent(){
	$sql = "SELECT * FROM EVENTS";
	$result = mysql_query($sql);
	var_dump($result);

	while($row = mysql_fetch_array($result)){
		echo "<option>".$row['NAME']."</option>";
	}
}

function populateAdmin() {
	$quer = "SELECT * FROM USERS";
	$res = mysql_query($quer);

	while($row = mysql_fetch_array($res)){
		if($row['ADMIN'] == 0){
			echo "<option>".$row['FIRSTNAME']." ".$row['LASTNAME']." ".$row['ADMIN']."</option>";
		}
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <!--<link rel="stylesheet" href="cgi-bin/css/main.css">-->
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="sylesheet" href = "cgi-bin/css/main.css">
		<script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.html">INSERT LOGO</a>
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
			<div class="container">
				<div class="row">
					<a class="btn btn-primary" href="ticketAdder.php" style="!text-decoration: none;">Add Ticket</a>
					<button class="btn btn-primary" style="!text-decoration: none;">Event Data</button>
					<?php
						if($_SESSION['admin'] == true){
							echo "<a class='btn btn-primary'href='eventAdder.php' style='text-decoration: none;''>Add Event</a>
										<button class='btn btn-primary' id='adminEdit'>Edit Admins</button>
										<a class='btn btn-primary' href='priceAdder.php'style='!text-decoration: none;'>Add Price</a>
							 			</div>
										<br />
											<div class='container' id='adminMenu'>
												<div class='row'>
													<div class='col-md-3'>
								            <div class='well' id='well2' style='overflow: auto;'>
								                <select class='form-control'>
																	<option disabled selected>
												            Users
												          </option>
												          <?php
												            populateAdmin();
												          ?>
																</select>
								            </div>
												</div>
							        </div>
											</div>
										<!--	<script>
											$(document).ready(function() {
													 $('#adminEdit').click(function() {
																$('#adminMenu').toggle('slide');
													 });
											 });
										 </script>-->";
			 			}
						if($_SESSION['admin'] == false){
							echo "<br />
										</div>";
						}
				 ?>
	    </div>
		<div>
			<div>
				<svg id="visualization1" width="1000" heigh="500">

				</svg>
			</div>
		</div>
		<div class="container">
			<div class="row">
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
				    .x(function(d) { return x(d.date); })
				    .y(function(d) { return y(d.close); });

				var svg = d3.select("body").append("svg")
				    .attr("width", width + margin.left + margin.right)
				    .attr("height", height + margin.top + margin.bottom)
				  .append("g")
				    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				d3.tsv("prices.tsv", function(error, data) {
				  if (error) throw error;

				  data.forEach(function(d) {
				    d.date = parseDate(d.date);
				    d.close = +d.close;
				  });

				  x.domain(d3.extent(data, function(d) { return d.date; }));
				  y.domain(d3.extent(data, function(d) { return d.price; }));

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
