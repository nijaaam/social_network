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
		$userID = clean_data($arr,'userID');
		$email = clean_data($arr,'email');
		$pass = clean_data($arr,'password');
		$q = clean_data($arr,'securityQuestion');
		$a = clean_data($arr,'securityAnswer');
		$query = "INSERT INTO users VALUES('$userID','email','pass','q','a') ON DUPLICATE KEY UPDATE email = 'email', password = 'pass', securityQuestion = '$q', securityAnswer = '$a'";
		mysql_query($query) or die(mysql_error());
	}

	function upload_personalInfo($arr){
		$query = "$arr['userID']";
		echo $query;
		mysql_query($query) or die(mysql_error());

	}
	if (isset($_FILES['xml']) && ($_FILES['xml']['error'] == UPLOAD_ERR_OK)) {
	    $xml = simplexml_load_file($_FILES['xml']['tmp_name']);       
	    $array = json_decode(json_encode($xml), TRUE);
	    upload_user($array['user']); 
	    upload_personalInfo($array['personalinfo']);       
	}
?>