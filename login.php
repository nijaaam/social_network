<?php
	include 'db.php';
	session_start();
	if (isset($_POST['submit1'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = md5(mysqli_real_escape_string($conn, $_POST['password']));
		$query = "SELECT * FROM `users` WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($conn,$query);
		if ($result && mysqli_num_rows($result) == 1){
			header("location: home.php");
			// TODO need to store who the logged in user is (and make home.php)
			exit();
		} else {
			header("location: index.php");
			exit();
		}
	}
?>

