<?php

  $mRootpath = "";
  $mFilepath = explode('/',dirname(__DIR__));
  foreach($mFilepath as $f){$mRootpath = $mRootpath.$f."/";if($f == "public_html"){break;}
  }
  define('ROOT_PATH', $mRootpath);

  include ROOT_PATH.'/public_html/base.php';

  function populateTicket(){
    $sql = "SELECT * FROM TICKET";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
      echo "<option>".$row['TID']."</option>";
    }
  }
/* I AM POSITIVE THE BELOW QUERY WORKS, NOT SURE WHY IT IS NOT LOADING CORRECT INFO.
  function populateTicket(){
    $sql = "SELECT E.NAME, S.SECTION, S.ROW, S.SEATNO FROM TICKET AS T, RSEAT AS S, EVENT AS E WHERE T.SID = R.SID AND E.EID = T.EID";
    $result = mysql_query($sql);
    var_dump($result);

    while($row = mysql_fetch_array($result)){
      echo "<option>Event: ".$row['NAME']." | Section: ".$row['SECTION']." | Row: ".$row['ROW']." | Seat: ".$row['SEATNO']."</option>";
    }
  }*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add Prices</title>
    <link rel="stylesheet" href="cgi-bin/css/main.css">
  	<!-- Latest compiled and minified CSS -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-default" role="navigation">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TicketMiner</a>
        <a class="btn btn-primary" href="_login.php"style="!text-decoration: none;">Dashboard</a>
      </div>
    </nav>
    <div class="container">
      <form class="form-horizontal" action="_priceAdder.php" method="post">
        <div class="form-group">
          <label for="events">Select a Ticket:</label>
          <select class="form-control" name="ticket">
            <option disabled>
              Tickets
            </option>
            <?php
              populateTicket();
            ?>
          </select>
        <div class="form-group"
            <div class="btn btn-default btn-file">
              Browse <input type="file" name="file">
            </div>
        </div>
        </div>
        <div class="form-group">
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
