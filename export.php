<?php
    ob_start();
    session_start();
    require_once 'dbconnect.php';
    $xml .= '<?xml version="1.0" encoding="utf-8"?>';
    $xml .= "\n";
    $xml .= "<data>\n";
    function get_xml($query,$name){
      $result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 
      $arr = mysql_fetch_array($result);
      $xml .= "<$name>\n";
      $numberfields = mysql_num_fields($result);
         for ($i=0; $i<$numberfields ; $i++ ) {
             $var = mysql_field_name($result, $i);
             $xml .= "\t<$var>";
             $xml .= $arr[$i];
             $xml .= "</$var>\n";
         }
      $xml .= "</$name>\n";
      return $xml;
    }
  if (isset($_POST['export'])) {
      $userId   = $_SESSION['user'];
      $query = "SELECT * FROM personalinfo WHERE personalinfo.userID='$userId'";
      $xml .= get_xml($query,"personalinfo");
      $query = "SELECT email,securityQuestion,securityAnswer FROM users WHERE users.userID='$userId'";
      $xml .= get_xml($query,"user");
      $query = "SELECT * FROM securitysettings WHERE userID='$userId'";
      $xml .= get_xml($query,"security");
      $query = "SELECT * FROM relationships WHERE userID1='$userId' OR userID2= '$userId' ";
      $xml .= get_xml($query,"friends");
      $query = "SELECT * FROM blogposts WHERE blogID = (SELECT blogID FROM blogs WHERE blogs.userID='$userId')";
      $xml .= get_xml($query,"blog");
      $xml .= "</data>\n";

     header("Content-Type: text/xml");

// It will be called downloaded.pdf
header('Content-Disposition: attachment; filename="data.xml"');

      echo $xml; 
  }
?>