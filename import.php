<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	function clean_data($arr,$id){
		$name = $arr[$id];
		$value = trim($name);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		return $value;
	}

	function upload_user($arr){
		$keys = array_keys($arr);
		$userID = $arr[$keys[0]];
		$email = $arr[$keys[1]];
		$pass = $arr[$keys[2]];
		$q = $arr[$keys[3]];
		$a = $arr[$keys[4]];
		$admin = $arr[$keys[5]];
		$query = "INSERT INTO users VALUES('$userID','$email','$pass','$q','$a','$admin')
		ON DUPLICATE KEY UPDATE 
		email = '$email', password = '$pass', securityQuestion = '$q', securityAnswer = '$a' , isAdmin = '$admin'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_personalInfo($arr){
		$keys = array_keys($arr);
		$id = $arr[$keys[0]];
		$fn = $arr[$keys[1]];
		$sn = $arr[$keys[2]];
		$gen = $arr[$keys[3]];
		$dob = $arr[$keys[4]];
		$city = $arr[$keys[5]];
		$country = $arr[$keys[6]];
		$query = "INSERT INTO personalinfo VALUES('$id','$fn','$sn','$gen','$dob','$city','$country')
		ON DUPLICATE KEY UPDATE 
		firstName = '$fn', surname = '$sn', gender = '$gen', birthday = '$dob', city = '$city', country = '$country'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_security($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$e = $arr[$keys[4]];
		$f = $arr[$keys[5]];
		$query = "INSERT INTO securitysettings VALUES('$a','$b','$c','$d','$e','$f')
		ON DUPLICATE KEY UPDATE 
		whoCanSeeBlog = '$b', whoCanSeeProfile = '$c', whoCanSendFriendRequests = '$d', visibleName = '$e', visiblePersonalInfo = '$f'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_friends($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$e = $arr[$keys[4]];
		$f = $arr[$keys[5]];
		$query = "INSERT INTO relationships VALUES('$a','$b','$c','$d','$e','$f')
		ON DUPLICATE KEY UPDATE invitationSentBy = '$c', invitationAccepted = '$d', timeRequestSent = '$e', timeRequestAccepted = '$f'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_posts($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$query = "INSERT INTO blogposts VALUES('$a','$b','$c','$d')
		ON DUPLICATE KEY UPDATE userID = '$b', dateTime = '$c', blogPostBody ='$d'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_photo($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = mysql_real_escape_string(base64_decode($arr[$keys[2]]));
		$d = $arr[$keys[3]];
		$e = $arr[$keys[4]];
		$f = $arr[$keys[5]];
		$query = "INSERT INTO photos VALUES('$a','$b','$c','$d','$e','$f')
		ON DUPLICATE KEY UPDATE photoCollectionID = '$b', image = '$c', name ='$d' , caption = '$e', dateUploaded = '$f'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_photoc($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$query = "INSERT INTO photocollections VALUES('$a','$b','$c','$d')
		ON DUPLICATE KEY UPDATE userID = '$b', name = '$c', whoCanSee ='$d'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_photolikes($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$query = "INSERT INTO photolikes VALUES('$a','$b')
		ON DUPLICATE KEY UPDATE userID = '$b'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_photocmnt($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$d = $arr[$keys[4]];
		$query = "INSERT INTO photocomments VALUES('$a','$b','$c','$d','$e')
		ON DUPLICATE KEY UPDATE userID = '$c', photoID = '$b', comment ='$d', dateTime = '$e'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_circles($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$query = "INSERT INTO circles VALUES('$a','$b','$c')
		ON DUPLICATE KEY UPDATE name = '$b', adminUserId = '$c'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_circle_member($arr){
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$query = "INSERT INTO circlememberships VALUES('$a','$b')
		ON DUPLICATE KEY UPDATE userID = '$b'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_circle_messages($arr){
		print_r($arr);
		$keys = array_keys($arr);
		$a = $arr[$keys[0]];
		$b = $arr[$keys[1]];
		$c = $arr[$keys[2]];
		$d = $arr[$keys[3]];
		$e = $arr[$keys[4]];
		$query = "INSERT INTO messagecircles VALUES('$a','$b','$c','$d','$e')
		ON DUPLICATE KEY UPDATE userID = '$c', circleID = '$b', message ='$d', timeSent = '$e'";
		mysql_query($query) or die(mysql_error());
	}

	if (isset($_FILES['xml']) && ($_FILES['xml']['error'] == UPLOAD_ERR_OK)) {
	    $xml = simplexml_load_file($_FILES['xml']['tmp_name']);       
	    $array = json_decode(json_encode($xml), TRUE);
	    upload_user($array['user']); 
	    upload_personalInfo($array['personalinfo']);
	    upload_security($array['security']);
	    foreach ($array['friends']['friend'] as $value) {
	    	upload_friends($value); 
	    } 
	    foreach ($array['blogs']['post'] as $value) {
	    	upload_posts($value); 
	    }
	    foreach ($array['photocollections']['photocollection'] as $value) {
	    	upload_photoc($value); 
	    } 
	    foreach ($array['photos']['photo'] as $value) {
	    	upload_photo($value);
	    }
	    foreach ($array['photolikes']['likes'] as $value) {
	    	upload_photolikes($value); 
	    }
	    foreach ($array['photocomments']['comments'] as $value) {
	    	upload_photocmnt($value);
	    }
	    foreach ($array['circles_admin']['circle'] as $value) {
	    	upload_circles($value); 
	    }
	    foreach ($array['circles_member']['circle'] as $value) {
	    	upload_circle_member($value); 
	    }
	    foreach ($array['circles_messages']['messages'] as $value) {
	    	upload_circle_messages($value); 
	    }        
	}
	header("location: profile.php");
	exit();
?>