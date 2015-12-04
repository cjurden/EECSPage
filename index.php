<?php
	$mRootpath = "";
	$mFilepath = explode('/',dirname(__DIR__));
	foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";//if($f == ""){break;}
														}
	define('ROOT_PATH', $mRootpath);

	include ROOT_PATH.'eecspage/base.php';
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
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
	<div class="jumbotron col-md-offset-1 col-md-10">
      <div class="container header">
        <h1>Welcome to TicketMiner</h1>
        <div class="row spacer">
        </div>
				<div class="row col-md-offset-1">
					<div class="col-md-3">
						<a class="btn btn-primary btn-lg" href="loginpage.php">Sign In</a>
					</div>
					<div class="col-md-3">
						<a class="btn btn-primary btn-lg" href="signup.php">Sign Up</a>
					</div>
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
