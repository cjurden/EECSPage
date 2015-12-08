<?php
    session_start();
    $mRootpath = "";
    $mFilepath = explode('/',dirname(__DIR__));
    foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
    }
    define('ROOT_PATH', $mRootpath);

    include ROOT_PATH.'public_html/base.php';

    if($_POST["firstName"] == null || $_POST["lastName"] == null || $_POST["username"] == null || $_POST["password"] == null || $_POST["inputEmail"] == null){
      session_destroy();
      header( 'Location: signup.php');
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
            $_SESSION['admin']    = $admin;
    		echo "<p>inserted data</p>";
    		$variables = [$firstname,
    									$lastname,
    									$username,
    									$password,
    									$email,
    									$admin];
    		var_dump($variables);
            header( 'Location: dashboard.php');
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

 ?>
