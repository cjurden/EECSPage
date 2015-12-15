<?php
  session_start();
  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}}
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'/public_html/base.php';
  
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
  function populateEvent(){
    $sql = "SELECT * FROM EVENT";
    $result = mysql_query($sql);
    if(!$result){
      echo "<p>
      failed to populate events
      </p>";
    }
    while($row = mysql_fetch_array($result)){
      var_dump($row);
      echo "<option>".$row['NAME']."</option>";
    }
  }

  function populateSection(){
    $sql = "SELECT * FROM RSEAT";
    $result = mysql_query($sql);
    var_dump($result);
    if(!$result){
      echo "<p>
      failed to populate sections
      </p>";
    }
    while($row = mysql_fetch_array($result)){
      echo "<option>".$row['SECTION']."</option>";
    }
  }

  function populateRow(){
    $sql = "SELECT * FROM RSEAT";
    $result = mysql_query($sql);
    var_dump($result);
    if(!$result){
      echo "<p>
      failed to populate row
      </p>";
    }
    while($row = mysql_fetch_array($result)){
      echo "<option>".$row['ROW']."</option>";
    }
  }

  function populateSeat(){
    $sql = "SELECT * FROM RSEAT";
    $result = mysql_query($sql);
    var_dump($result);
    if(!$result){
      echo "<p>
      failed to populate seat
      </p>";
    }

    while($row = mysql_fetch_array($result)){
      echo "<option>".$row['SEATNO']."</option>";
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add Ticket</title>
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
    <form class="form-horizontal" action="_seatAdder.php" method="post">
      <div class="form-group">
        <label for="events">Select an Event:</label>
        <select class="form-control" name="event">
          <option disabled >
            Events
          </option>
          <?php
            populateEvent();
          ?>
        </select>
      </div>
      <div class="form-group">
            <label for="events">Section:</label>
          <select class="form-control" name="section">
            <option disabled selected>Section</option>
            <?php populateSection(); ?>
          </select>
      </div>
      <div class="form-group">
          <label for="events">Row:</label>
          <select class="form-control" name="row">
            <option disabled selected>Row</option>
            <?php populateRow();?>
          </select>
      </div>
        <div class="form-group">
          <label for="events">Seat No:</label>
          <select class="form-control" name="seat">
            <option disabled selected>Seat</option>
            <?php populateSeat();?>
          </select>
        </div>
        <div class="form-group">
          <input class='btn btn-primary col-sm-offset-6' type="submit" value= 'Submit'>
        </div>
    </div>
  </form>
  </body>
  <!-- Latest compiled and minified JavaScript -->
  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="cgi-bin/js/bootstrap.min.js"></script>
  <!-- jquery -->
</html>
