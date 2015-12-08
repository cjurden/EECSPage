<?php
  session_start();
  //var_dump($_SERVER['HTTP_REFERER']);
  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
  }
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'public_html/base.php';

  $sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'";
  // Check to see if the query fails
  if(!mysql_query($sql, $database)){
  	echo "<p>Query Failed!</p>";
  }

  $result = mysql_query($sql,$database);
  if($result && mysql_num_rows($result) > 0){
  	// If there are no rows with this username and password combination then redirect the user
  	header( 'Location: dashboard.php' );
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="cgi-bin/css/main.css">
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TicketMiner</a>
      </div>
      <div class="nav navbar-nav navbar-left">
        <button class="btn btn-default">Log Out</button>
      </div>
    </nav>
    <div class='jumbotron'>
      <div class="container">
        <form class="form-horizontal" action="dashboard.php" method="post">
          <div class="form-group">
            <label for="email">Username:</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name="password">
          </div>
          <input type="submit" class="btn btn-default">
        </form>
      </div>
    </div>
  </body>
  <!-- Latest compiled and minified JavaScript -->
  <script src="cgi-bin/js/bootstrap.min.js"></script>
  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
  <!-- jquery -->
</html>
