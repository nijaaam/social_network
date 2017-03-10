<?php
ob_start();
session_start();
require_once 'dbconnect.php';
$xml .= '<?xml version="1.0" encoding="utf-8"?>';
$xml .= "\n";
$xml .= "<data>\n";
function get_xml($query, $name)
{
    $result = mysql_query($query) or die("Error in query: $query. " . mysql_error());
    $arr = mysql_fetch_array($result);
    $xml .= "<$name>\n";
    $numberfields = mysql_num_fields($result);
    for ($i = 0; $i < $numberfields; $i++) {
        $var = mysql_field_name($result, $i);
        $xml .= "\t<$var>";
        if ($var == "picture"){
            $xml .= base64_encode($arr[$i]);
        }else{
            $xml .= $arr[$i];
        }
        $xml .= "</$var>\n";
    }
    $xml .= "</$name>\n";
    return $xml;
}

function get_xml2($query, $name, $name2)
{
    $result = mysql_query($query) or die("Error in query: $query. " . mysql_error());
    $xml .= "<$name>\n";
    $numberfields = mysql_num_fields($result);
    
    while ($arr = mysql_fetch_array($result)) {
        $xml .= "\t<$name2>";
        for ($i = 0; $i < $numberfields; $i++) {
            $var = mysql_field_name($result, $i);
            $xml .= "\t<$var>";
            if ($var == "image" || $var == "picture" ){
                $xml .= base64_encode($arr[$i]);
            }else {
              $xml .= $arr[$i];
            }
            $xml .= "</$var>\n";
        }
        $xml .= "</$name2>\n";
    }
    
    $xml .= "</$name>\n";
    return $xml;
}

if (isset($_POST['export'])) {
    $userId = $_SESSION['user'];
    $query  = "SELECT * FROM personalinfo WHERE personalinfo.userID='$userId'";
    $xml .= get_xml($query, "personalinfo");
    $query = "SELECT * FROM users WHERE users.userID='$userId'";
    $xml .= get_xml($query, "user");
    $query = "SELECT * FROM securitysettings WHERE userID='$userId'";
    $xml .= get_xml($query, "security");
    $query = "SELECT * FROM relationships WHERE  invitationAccepted = 1 and userID1 = $userId";
    $xml .= get_xml2($query, "friends", "friend");
    $query = "SELECT * FROM blogposts WHERE userID = $userId";
    $xml .= get_xml2($query, "blogs", "post");
    $query = "SELECT * FROM photocollections WHERE userID = $userId";
    $xml .= get_xml2($query, "photocollections","photocollection");
    $query = "SELECT * from photos where photoCollectionID IN (select photoCollectionID from photocollections where userID = $userId);";
    $xml .= get_xml2($query, "photos","photo");
    $query = "SELECT * from photolikes where userID = $userId;";
    $xml .= get_xml2($query, "photolikes","likes");
    $query = "SELECT * from photocomments where userID = $userId;";
    $xml .= get_xml2($query, "photocomments","comments");
    $query = "SELECT * from circles where adminUserID = $userId;";
    $xml .= get_xml2($query, "circles_admin","circle");
    $query = "SELECT * from circlememberships where userID = $userId;";
    $xml .= get_xml2($query, "circles_member","circle");
    $query = "SELECT * from messagecircles where userID = $userId;";
    $xml .= get_xml2($query, "circles_messages","messages");
    $xml .= "</data>\n";
    
    header("Content-Type: text/xml");
    
    // It will be called downloaded.pdf
    header('Content-Disposition: attachment; filename="data.xml"');
    
    echo $xml;
}
?>