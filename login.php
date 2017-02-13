<?php
	include 'db.php';
	session_start();
	if (isset($_POST['submit1'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = md5(mysqli_real_escape_string($conn, $_POST['password']));
		$query = "SELECT * FROM users WHERE userID = $username AND password = $password";
		$result = mysqli_query($conn,$query);
		if ($result && mysql_num_rows($result) == 1){
			header("location: home.php");
			exit();
		} else {
			header("location: index.php");
			exit();
		}
	}
?>

