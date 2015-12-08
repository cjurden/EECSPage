<?php
  session_start();
  $mIsValidUser = false;
  var_dump($_POST);
  if($_POST["username"]!= null && $_POST["password"]!= null){

    //If there is a unsername varible in the post array then put it into the session
    //array.
    if(isset($_POST["username"])){
      $_SESSION["username"] = $_POST["username"];
    }else{
      $_SESSION['username'] = "";
    }

    //If there is a unsername varible in the post array then put it into the session
    //array.
    if(isset($_POST['password'])){
      $_SESSION['password'] = $_POST['password'];
    }else{
      $_SESSION['password'] = "";
    }
  }

  //this may be only for the login page, not signup, must pass a variable that shows where you are originating from
  //session_start(); <--- You need this if the session has not yet been started
  $sql = "SELECT * FROM USERS WHERE USERNAME='".$_SESSION['username']."' AND PASSWORD='".$_SESSION['password']."'";
  // Check to see if the query fails
  $result = mysql_query($sql);
  if(!$result){
    var_dump($_SESSION);
    echo "<p>Query Failed!</p>";
  }

  if($result && mysql_num_rows($result) == 0){
    // If there are no rows with this username and password combination then redirect the user
    session_destroy();
    header( 'Location: index.php' );
  }
  else if ($result){
    header( 'Location: dashboard.php');
  }
 ?>
