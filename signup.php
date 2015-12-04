<?php
	$mRootpath = "";
	$mFilepath = explode('/',dirname(__DIR__));
foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";//if($f == "eecspage"){break;}
}
	define('ROOT_PATH', $mRootpath);

	include ROOT_PATH.'base.php';
  var_dump($_POST);
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
        <a class="navbar-brand" href="index.html">INSERT LOGO</a>
      </div>
    </nav>
    <div class="page-header col-sm-offset-1 col-sm-10">
      <h1>Sign Up For TicketMiner</h1>
    </div>
    <form class="form-horizontal" action="dashboard.php" method="post">
      <div class="form-group">
        <label for="firstName" class="col-sm-2 control-label">FirstName</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="firstName" placeholder="First Name">
        </div>
      </div>
      <div class="form-group">
        <label for="lastName" class="col-sm-2 control-label">Last Name</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="lastName" placeholder="Last Name">
        </div>
      </div>
      <div class="form-group">
        <label for="username" class="col-sm-2 control-label">Username</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="username" placeholder="Username">
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-9">
          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
        </div>
      </div>
      <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-9">
          <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
      </div>
			<!--
      <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Confirm Password</label>
        <div class="col-sm-9">
          <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
      </div>-->
      <div class="row">
        <input class='btn btn-primary col-sm-offset-6' type="submit" value= 'Submit'>
      </div>
      </div>
    </div>
  </body>
  <!-- Latest compiled and minified JavaScript -->
  <script src="cgi-bin/js/bootstrap.min.js"></script>
  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
  <!-- jquery -->
</html>
