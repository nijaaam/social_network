<?php
	include 'db.php';
	session_start();
	if (isset($_POST['submit'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$password = md5(mysqli_real_escape_string($conn, $_POST['password']));
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$question = mysqli_real_escape_string($conn, $_POST['question']);
		$answer = mysqli_real_escape_string($conn, $_POST['answer']);
		$query = "INSERT INTO users (email,password,securityQuestion,securityAnswer,username) VALUES('$email','$password','$question','$answer','$username')";
		if (mysqli_query($conn, $query)) {
		    $last_id = mysqli_insert_id($conn);
		    echo "New record created successfully. Last inserted ID is: " . $last_id;
		    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
			$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
		}
	}
?>