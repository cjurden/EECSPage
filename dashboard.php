<?php
var_dump($_POST);

session_start();

$mRootpath = "";
$mFilepath = explode('/',dirname(__DIR__));
foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";//if($f == "eecspage"){break;}
}
define('ROOT_PATH', $mRootpath);

include ROOT_PATH.'/eecspage/base.php';



if(!empty($_POST)){
	$firstname  = ($_POST["firstName"]);
	$lastname   = ($_POST["lastName"]);
	$username   = ($_POST["username"]);
	$password   = ($_POST["password"]);
	$email      = ($_POST["inputEmail"]);
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

	$add = mysql_query("INSERT INTO USERS VALUES('".$firstname."', '".$lastname."', '".$username."', '".$email."', '".$password."')");
	mysql_close($database);
	if($add){
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		echo "<p>inserted data</p>";
		$variables = [$firstname,
									$lastname,
									$username,
									$password,
									$email];
		var_dump($variables);
	}
	else {
		var_dump($text);
		$variables = [$firstname,
									$lastname,
									$username,
									$password,
									$email];
		var_dump($variables);
	}
	//need to show errors at some point....
}


$mIsValidUser = false;
if(!empty($_POST)){

	//If there is a unsername varible in the post array then put it into the session
	//array.
	if(isset($_POST['un'])){
		$_SESSION['username'] = $_POST['un'];
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


//session_start(); <--- You need this if the session has not yet been started
$sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'";
// Check to see if the query fails
if(!mysql_query($sql,$database)){
	echo "<p>Query Failed!</p>";
}

$result = mysql_query($sql,$database);
if($result && mysql_numrows($result) == 0){
	// If there are no rows with this username and password combination then redirect the user
	header( 'Location: index.php' );
}

if($_POST['row'] == null || $_POST['section'] == null || $_POST['seat'] == null){
	//do nothing
}else{
  $ticket = "SELECT SID FROM RSEAT WHERE ROW = '".$_POST['row']."' AND SECTION = '".$_POST['section']."' AND SEATNO = '".$_POST['seat']."')";
  $insertTicket = "INSERT INTO TICKET (SID) VALUES ('".$ticket."')"; //insert query to get post variables from add ticket and activate the ticket
  mysql_query($insertTicket, $database);

  $activateSeat = "INSERT INTO SEAT (SID) VALUES('".$ticket."')";
  mysql_query($activateSeat, $database);
}


//is there a better way to determine WHICH page the user is coming from?
if($_POST['name'] == null || $_POST['type'] == null || $_POST['date'] == null || $_POST['venue'] == null){
	//do something
}else{
	$VIDquer = "SELECT VID FROM VENUE WHERE NAME = '".$_POST['venue']."'";
	$vid = mysql_query($VIDquer, $database);
  $event = "INSERT INTO EVENT (NAME, TYPE, DATE, VID) VALUES ('".$_POST['name']."', '".$_POST['type']."', '".$_POST['date']."', '".$_POST['venue']."')";
}


function populateEvent(){
	$sql = "SELECT * FROM EVENTS WHERE ";
	$result = mysql_query($sql,$database);
	var_dump($result);

	while($row = mysql_fetch_array($result)){
		echo "<option>".$row['NAME']."</option>";
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
  	<link rel="stylesheet" href="cgi-bin/css/bootstrap.min.css">
    <link rel="sylesheet" href = "cgi-bin/css/dash.css">

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
        <select class="col-md-4 col-md-offset-1">
          <option disabled selected>
            Events
          </option>
          <?php
            //populateEvent()
          ?>
        </select>
        <button class="btn btn-primary">Add Ticket</button>
      </div>
    </div>
    <script src="cgi-bin/js/d3.min.js" charset="utf-8"></script>
    <script src='cgi-bin/js/graph.js'></script>
  </body>
  <!-- Latest compiled and minified JavaScript -->

  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="cgi-bin/js/bootstrap.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
  <!-- jquery -->
</html>
