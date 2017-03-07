<?php
ob_start();
session_start();
require_once 'dbconnect.php';
require_once 'validation_functions.php';

if ( isset($_SESSION['user'])!="" ) {
	header("Location: profile.php");
	exit;
}

$error = false;

if( isset($_POST['btn_submit_email']) ) {	

	// prevent sql injections/ clear user invalid inputs
	$email = clean_data('email');
	$emailError = validate_email($email);

	//check if the email address exists
	if(!isset($emailError)){
		$query = "SELECT email FROM users WHERE email='$email'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		if($count == 0){
			$error = true;
			$emailError = "The email address provided is not associated with an account";
		}	
		else{
			//email exists, now get security question
			$emailAccepted = true;
			$query = "SELECT securityQuestion, securityAnswer FROM users WHERE email='$email'";
			$result = mysql_query($query);
			$data = mysql_fetch_assoc($result);
			$question = $data['securityQuestion'];
			$answer = $data['securityAnswer'];
			switch ($question){
				case "favourite teacher":
				$question = "What was the name of your favourite teacher?";
				break;
				case "pets name":
				$question = "What was the name of your first pet?";
				break;
				default:
				$question = "What was the name of your elementary / primary school";
			}
		}
	}

	if(isset($_POST['securityAnswer'])){
		$securityAnswer = clean_data('securityAnswer');
		$answerError = validate('answer', $securityAnswer, 2);

		if(!isset($answerError)){
		//compare the two answers
			if($answer === $securityAnswer){
				$authenticated = true;
			}
			else{
				$error = true;
				$answerError = "The answer you provided does not match";
			}
		}
		if($authenticated === true && isset($_POST['pass'])){
			//compare passwords
			$pass = clean_data('pass');
			$passError = validate('password', $pass, 6);

			if(!isset($passError)){
				//everything matches, now update sql
				$password = hash('sha256', $pass);

				$query = "START TRANSACTION;";
				$res = mysql_query($query);
				$query = "UPDATE users SET password='$password' WHERE email='$email'";
				$res = mysql_query($query);

				$query = "COMMIT;";            

				$res = mysql_query($query) or die(mysql_error());

				if ($res) {
					$errTyp = "success";
					$errMSG = "Password successfully changed, you may login now";
					unset($password);
					unset($emailAccepted);
					unset($securityAnswer);
				} else {
					$errTyp = "danger";
					$errMSG = "Something went wrong, try again later...";	
				}
			}
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
			<form name="reset_pass" method="post" <?php echo "action=\"".htmlspecialchars($_SERVER['PHP_SELF']) ."\""; if($authenticated===true){echo "onsubmit=\"return validatePass()\"";}?> autocomplete="off">

				<div class="col-md-12">

					<div class="form-group">
						<h2 class="">Reset Password.</h2>
					</div>

					<div class="form-group">
						<hr />
					</div>


					<?php
					if ( isset($errMSG) ) {

						?>
						<div class="form-group">
							<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
								<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
							</div>
						</div>
						<div class="form-group" <?php if($errTyp=="danger"){ echo "hidden";} ?> >
							<a href="index.php?email=<?php echo "$email"; ?>" class="btn btn-primary btn-block">Sign in</a>
						</div>
						<?php
					}
					?>

					<div <?php if(isset($errMSG)){ echo "hidden";} ?>>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $email; ?>" maxlength="40" />
						</div>
						<span class="text-danger"><?php echo $emailError; ?></span>
					</div>

					<div  <?php if(!isset($emailAccepted)){ echo "hidden";} ?> >

						<div class="form-group">
							<hr />
						</div>

						<h5><?php echo $question; ?></h5>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"></span>
								<input  <?php if(!isset($emailAccepted)){ echo "disabled";} ?> type="text" name="securityAnswer" class="form-control" placeholder="Answer" value= "<?php echo $securityAnswer; ?>"maxlength="40" />
							</div>
							<span class="text-danger"><?php echo $answerError; ?></span>
						</div>

						<div <?php if($authenticated != true){ echo "hidden";} ?> >
							<div class="form-group">
								<hr />
							</div>
							<h5>Enter your new password details</h5>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input <?php if($authenticated != true){ echo "disabled";} ?> type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
								</div>
								<span class="text-danger"><?php echo $passError; ?></span>
							</div>

							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input <?php if($authenticated!=true){ echo "disabled";} ?> type="password" name="pass_confirm" class="form-control" placeholder="Confirm Password" maxlength="15" />
								</div>
								<span class="text-danger"><?php echo $passError; ?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" name="btn_submit_email">Submit</button>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<div class="form-group">
						<a href="index.php">Sign in Here...</a>
					</div>
					</div>

				</div>

			</form>
		</div>	

	</div>

</body>
</html>
<?php ob_end_flush(); ?>

<script>
	function validatePass(){
		var a = document.forms["reset_pass"]["pass"].value;
		var b = document.forms["reset_pass"]["pass_confirm"].value;

		if (a!=b){
			alert("Passwords do not match.");
			return false;
		}
	}
</script>
