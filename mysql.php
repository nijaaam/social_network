<?php 
  $host = "us-cdbr-azure-southcentral-f.cloudapp.net";
  $user = "b9dee02f541f7c";
  $pass = "70d033d3";

  $databaseName = "socialcw";
  $tableName = "users";

  include 'DB.php';
  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------
  $result = mysql_query("SELECT * FROM $tableName");          //query
  $array = mysql_fetch_row($result);                          //fetch result    

  //--------------------------------------------------------------------------
  // 3) echo result as json 
  //--------------------------------------------------------------------------
  echo json_encode($array);

?>