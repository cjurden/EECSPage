<?php
  session_start();
  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}}
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'/public_html/base.php';

  $sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'";
  // Check to see if the query fails
  if(!mysql_query($sql, $database)){
  	echo "<p>Query Failed!</p>";
  }

  $result = mysql_query($sql,$database);
  if($result && mysql_num_rows($result) == 0){
  	// If there are no rows with this username and password combination then redirect the user
  	header( 'Location: index.php' );
  }
  if($_SESSION['admin'] == false){
    	header( 'Location: dashboard.php' );
  }

  function populateType(){
    $sql = "SELECT * FROM EVENTS";
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
    <title>Add Event</title>
  	<!-- Latest compiled and minified CSS -->

  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TicketMiner</a>
        <a class="btn btn-primary" href="_login.php"style="!text-decoration: none;">Dashboard</a>
      </div>
    </nav>
    <div class="container">
    <form class="form-horizontal" action= "_eventAdder.php" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
      </div>
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" placeholder="Date" name="date">
      </div>
      <div class="form-group">
          <label for="events">Type:</label>
          <input type="text" class="form-control" id="type" placeholder="Type" name="type">
      </div>
        <div class="form-group">
          <label for="venue">Venue:</label>
          <input type="text" class="form-control" id="venue" placeholder="Venue" name="venue">
        </div>
        <div class="form-group">
          <input class='btn btn-primary col-sm-offset-6' type="submit" value= 'Submit' href="dashboard.html">
        </div>
    </form>
  </div>
  </body>
  <!-- Latest compiled and minified JavaScript -->
  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="cgi-bin/js/bootstrap.min.js"></script>
  <!-- jquery -->
</html>
