<?php
	$mRootpath = "";
	$mFilepath = explode('/',dirname(__DIR__));
	foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "eecspage"){break;}}
	define('ROOT_PATH', $mRootpath);

	include ROOT_PATH.'cgi-bin/php/base.php';
  var_dump($_POST);
  /*
  if(isset($_POST['signup'])){
    $firstname  = mysql_real_escape_string($_POST['firstname']);
    $lastname   = mysql_real_escape_string($_POST['lastname']);
		$username   = mysql_real_escape_string($_POST['username']);
    $password   = mysql_real_escape_string($_POST['password']);
    $email      = mysql_real_escape_string($_POST['email']);
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


    $add = mysql_query("INSERT INTO USERS VALUES('$firstname', '$lastname', '$username', '$password', '$email')");
    mysql_close($database);
    if($add){
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
    }
    else {
      $action['result'] = 'error';
      array_push($text, 'user could not be added to database. error: ' . mysql_error());
      $action['text'] = $text;
      echo "<script type='text/javascript'> alert (". $text[0] ."); </script>";
    }
    //need to show errors at some point....
	}
  */
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
    <div class="form-horizontal">
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
        <input class='btn btn-primary col-sm-offset-6' type="submit" value= 'Submit' href="dashboard.php">
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
