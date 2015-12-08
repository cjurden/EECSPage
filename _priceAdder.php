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
  else if($result){
    function write_tabbed_file($filepath, $array, $save_keys=false){
        $content = '';

        reset($array);
        while(list($key, $val) = each($array)){

            // replace tabs in keys and values to [space]
            $key = str_replace("\t", " ", $key);
            $val = str_replace("\t", " ", $val);

            if ($save_keys){ $content .=  $key."\t"; }

            // create line:
            $content .= (is_array($val)) ? implode("\t", $val) : $val;
            $content .= "\n";
        }

        if (file_exists($filepath) && !is_writeable($filepath)){
            return false;
        }
        if ($fp = fopen($filepath, 'w+')){
            fwrite($fp, $content);
            fclose($fp);
        }
        else { return false; }
        return true;
    }
    //coming from price adder
    if($_POST['ticket'] == null || $_POST['file'] == null) {
      //do something
      echo "<p>not coming from price adder!</p>";
    }else{
      $tid = $_POST['ticket'];
      var_dump($tid);
      $file = fopen($_POST['file'], "r");
      while(! feof($file))
      {
        $price = (fgetcsv($file));
        $event = "INSERT INTO PRICE (TID, PRICE) VALUES ('".$tid."', '".$price[0]."')";
        $result = mysql_query($event);
      }
      $quer = "SELECT * FROM PRICE";
      $array = mysql_query($quer);
      $arr = mysql_fetch_array($array);
      var_dump($arr);
      write_tabbed_file('prices.tsv', $arr, true);
    }
  header( 'Location: dashboard.php' );
  }
?>
