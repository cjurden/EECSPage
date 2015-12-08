<?php
  session_start();
  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
  }
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'public_html/base.php';

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
  else if ($result){
    if(!isset($_POST)){
    	//do something
    	echo "<p>not coming from event adder!</p>";
    }else{
    	$VIDquer = "SELECT VID FROM VENUE WHERE NAME = ".$_POST['venue']." GROUP BY VID";
    	$vid = mysql_query($VIDquer);
      $check = "SELECT * FROM EVENT WHERE NAME = '".$_POST['name']."' AND TYPE = '".$_POST['type']."' AND DATE = '".$_POST['date']."' AND VID = '".$vid."'";
      $checker = mysql_query($check);
      if($checker && mysql_num_rows($result) == 0){
        // If there are no rows with this username and password combination then redirect the user
        $event = "INSERT INTO EVENT (NAME, TYPE, DATE, VID) VALUES ('".$_POST['name']."', '".$_POST['type']."', '".$_POST['date']."', '".$vid."')";
      	$result = mysql_query($event);
      	if(!$result){
      		echo "<p>
      		unsuccessful insertion of event
      		</p>";
      	}else {
          if($_SESSION['admin'] == true){
            header( 'Location: Adashboard.php' );
          } else if($_SESSION['admin'] == false){
            header( 'Location: dashboard.php' );
          }
      	}
      }
      else if($checker && mysql_num_rows($result) > 0) {
        if($_SESSION['admin'] == true){
          header( 'Location: Adashboard.php' );
        } else if($_SESSION['admin'] == false){
          header( 'Location: dashboard.php' );
        }
      }
    }
  }
?>
