<?php
  session_start();
  //var_dump($_SERVER['HTTP_REFERER']);
  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
  }
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'public_html/base.php';
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
  </body>
  <!-- Latest compiled and minified JavaScript -->
  <script src="cgi-bin/js/bootstrap.min.js"></script>
  <script src="cgi-bin/js/angular.min.js"></script>
  <script src="cgi-bin/js/main.js"></script>
  <!-- jquery -->
</html>
