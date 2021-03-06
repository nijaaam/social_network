<?php
ob_start();
session_start();
require_once 'dbconnect.php';
include_once 'validation_functions.php';

	// it will never let you open index(login) page if session is set
if ( isset($_SESSION['user'])!="" ) {
	header("Location: profile.php");
	exit;
}

$error = false;

if( isset($_GET['email'])){
	$email = $_GET['email'];
}

if( isset($_POST['btn-login']) ) {	
	
		// prevent sql injections/ clear user invalid inputs
	$email = clean_data('email');
	$pass = clean_data('pass');

		// prevent sql injections / clear user invalid inputs
	$emailError = validate_email($email);
	$passError = validate('password', $pass, 6);
	
		// if there's no error, continue to login
	if (!$error) {
		
			$password = hash('sha256', $pass); // password hashing using SHA256
			
			$res=mysql_query("SELECT userId, password FROM users WHERE email='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['password']==$password ) {
				$_SESSION['user'] = $row['userId'];
				$_SESSION['email'] = $email;
				header("Location: profile.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
			
		}
		
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Social Network</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>

		<div class="container">

			<div id="login-form">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
					
					<div class="col-md-12">
						
						<div class="form-group">
							<h2 class="">Sign In.</h2>
						</div>
						
						<div class="form-group">
							<hr />
						</div>
						
						<?php
						if ( isset($errMSG) ) {
							
							?>
							<div class="form-group">
								<div class="alert alert-danger">
									<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
								</div>
							</div>
							<?php
						}
						?>
						
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
								<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
							</div>
							<span class="text-danger"><?php echo $emailError; ?></span>
						</div>
						
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
							</div>
							<span class="text-danger"><?php echo $passError; ?></span>
						</div>
						<a href="reset_password.php">I forgot my password...</a>
						
						<div class="form-group">
							<hr />
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
						</div>
						
						<div class="form-group">
							<hr />
						</div>
						
						<div class="form-group">
							<a href="register.php">Sign Up Here...</a>
						</div>
						
					</div>
					
				</form>
			</div>	

		</div>

	</body>
	</html>
	<?php ob_end_flush(); ?>
