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
    else{
      $sid = mysql_query("SELECT SID FROM RSEAT WHERE ROW = '".$_POST["row"]."' AND SECTION = '".$_POST["section"]."' AND SEATNO = '".$_POST["seat"]."' GROUP BY SID");
    	$eid = mysql_query("SELECT EID FROM EVENT WHERE NAME = '".$_POST['event']."' GROUP BY EID");
      //check for duplicate values
      $check = "SELECT * FROM TICKET WHERE EID = '".$eid."' AND VID = '".$vid."'";
      $checker = mysql_query($check);
      if($checker && mysql_num_rows($result) == 0){
        // If there are no rows with this username and password combination then redirect the user
        $insertTicket = "INSERT INTO TICKET (EID, SID) VALUES ('".$eid."','".$sid."')"; //insert query to get post variables from add ticket and activate the ticket
        $R1 = mysql_query($insertTicket);
      	if(!$R1){
      		echo "<p>
      		 insert into ticket failed
      		</p>";
      	}
        $activateSeat = "INSERT INTO SEAT (SID) VALUES('".$sid."')";
        $R2 = mysql_query($activateSeat);
      	if(!$R2){
      		echo "<p>
      		 insert into seat table failed
      		</p>";
      	}
      if($R2 && $R1){
        if($_SESSION['admin'] == true){
          header( 'Location: Adashboard.php' );
        } else if($_SESSION['admin'] == false){
          header( 'Location: dashboard.php' );
        }
      }
    }
    else if ($result){
      if(!isset($_POST)){
      	echo "<p>Not coming from seat adder!</p>";
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
