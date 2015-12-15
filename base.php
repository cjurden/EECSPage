<?php
$userName='njurden';
$password='Password123!';

/* ---------------------------------------------------------*/
/* -- ALLOW RELATIVE 										*/
/* -- ------------------------------------------------------*/
$mRootpath = "";
$mFilepath = explode('/',dirname(__DIR__));
foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}}
define('ROOT_PATH', $mRootpath);

/* ---------------------------------------------------------*/
/* -- PHP ERROR REPORTING									*/
/* -- ------------------------------------------------------*/
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* ---------------------------------------------------------*/
/* -- PHP DATABASE CONNECTION 								*/
/* -- ------------------------------------------------------*/

// Open Database Connection
$database = @mysql_connect('mysql.eecs.ku.edu', $userName, $password);
if(!$database) {
	die('Could not connect: ' . mysql_error());
}

if(!mysql_select_db($userName, $database)){
	die('Could not select database: ' . mysql_error());
}

$sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'AND ADMIN = '".$_SESSION['admin']."'";
// Check to see if the query fails
$result = mysql_query($sql);
if(!$result){
	var_dump($_SESSION);
	echo "<p>Query Failed!</p>";
}

if($result && mysql_num_rows($result) == 0){
	// If there are no rows with this username and password combination then redirect the user
	session_destroy();
	header( 'Location: login.php' );
}

/* ---------------------------------------------------------*/
/* -- PHP "INCLUDE" STATEMENTS								*/
/* -- ------------------------------------------------------*/
/*
$sql = "SELECT * FROM CRUISE";
$result = mysql_query($sql,$database);
var_dump($result);

while($row = mysql_fetch_array($result)){
	echo "<pre>";
	var_dump($row);
	echo "</pre>";
}

function populateCruise(){
	$sql = "SELECT * FROM CRUISE";
	$result = mysql_query($sql,$database);
	var_dump($result);

	while($row = mysql_fetch_array($result)){
		echo "<option>".$row['CRUISENUM']."</option>";
	}
}

echo "<pre>";
var_dump($_GET); //this is how we can verify admin - by getting variable passed in url
echo "</pre>";
*/
?>
