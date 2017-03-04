<?php
ob_start();
session_start();
if( isset($_SESSION['user'])!="" ){
	header("Location: profile.php");
}
require_once 'dbconnect.php';
include_once 'validation_functions.php';

$error = false;

if ( isset($_POST['btn-signup']) ) {

		// clean user inputs to prevent sql injections
	$firstName = clean_data('firstName');
	$surname = clean_data('surname');
	$email = clean_data('email');
	$gender = clean_data('gender');
	$city = clean_data('city');
	$country= clean_data('country');
	$birthday = clean_data('birthday');
	$securityQuestion = clean_data('securityQuestion');
	$securityAnswer = clean_data('securityAnswer');
	$pass = clean_data('pass');

		// basic validation
	$firstNameError = validate('first name', $firstName, 2 ,true);
	$surnameError = validate('surname', $surname, 2, true);
	$cityError = validate('city', $city, 3, true);
	$countryError = validate('country', $country, 4, true);
	$securityAnswerError = validate('answer', $securityAnswer, 2);
	$birthdayError = validate('birthday', $birthday, 10);
	$passError = validate('password', $pass, 6);
	$genderError = validate_select('gender', $gender);
	$securityQuestionError = validate_select('security question', $securityQuestion);
	$emailError = validate_email($email, true);

		// password encrypt using SHA256();
	$password = hash('sha256', $pass);

		// if there's no error, continue to signup
	if( !$error ) {
		$query = "START TRANSACTION;";
		$res = mysql_query($query);
		$query = "INSERT INTO users(email,password,securityQuestion,securityAnswer) 
		VALUES('$email','$password','$securityQuestion', '$securityAnswer');";
		$res = mysql_query($query);
		$query = "INSERT INTO personalinfo(userID, firstName, surname, gender, city, country, birthday) VALUES((SELECT userID from users WHERE email = '$email'),'$firstName','$surname','$gender','$city','$country','$birthday');";
		$res = mysql_query($query);
		$query = "INSERT INTO securitysettings(userID) VALUES ((SELECT userID from users WHERE email = '$email'));";
		$res = mysql_query($query);

		$query = "COMMIT;";            

		$res = mysql_query($query) or die(mysql_error());

		if ($res) {
			$errTyp = "success";
			$errMSG = "Successfully registered, you may login now";
			unset($name);
			unset($email);
			unset($pass);
		} else {
			$errTyp = "danger";
			$errMSG = "Something went wrong, try again later...";	
		}			
	}
}
else{
	$gender='';
	$securityQuestion='';
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
			<form name="registerForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validatePass()" autocomplete="off">

				<div class="col-md-12">

					<div class="form-group">
						<h2 class="">Sign Up.</h2>
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
						<?php
					}
					?>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="firstName" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $firstName ?>" />
						</div>
						<span class="text-danger"><?php echo $firstNameError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" name="surname" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $surname ?>" />
						</div>
						<span class="text-danger"><?php echo $surnameError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<select name="gender", class= "form-control">
								<option value="" <?php if($gender == ''){echo("selected");}?> disabled hidden>Gender</option>
								<option <?php if($gender == 'Male'){echo("selected");}?> value="Male">Male</option>
								<option <?php if($gender == 'Female'){echo("selected");}?> value="Female">Female</option>
							</select>
						</div>
						<span class="text-danger"><?php echo $genderError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="email" name="email" class="form-control" placeholder="Email" maxlength="40" value="<?php echo $email ?>" />
						</div>
						<span class="text-danger"><?php echo $emailError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
						</div>
						<span class="text-danger"><?php echo $passError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" name="pass_confirm" class="form-control" placeholder="Confirm Password" maxlength="15" />
						</div>
						<span class="text-danger"><?php echo $passError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon"></span></span>
							<input type="date" name="birthday" class="form-control" placeholder="Birthday (yyyy-mm-dd)" maxlength="50" value="<?php echo $birthday ?>" />
						</div>
						<span class="text-danger"><?php echo $birthdayError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon"></span></span>
							<input type="text" name="city" class="form-control" placeholder="City" maxlength="50" value="<?php echo $city ?>" />
						</div>
						<span class="text-danger"><?php echo $cityError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon"></span></span>
							<input type="text" name="country" class="form-control" placeholder="Country" maxlength="50" value="<?php echo $country ?>" />
						</div>
						<span class="text-danger"><?php echo $countryError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"></span>
							<select name="securityQuestion", class= "form-control">
								<option value="" <?php if($securityQuestion == ''){echo("selected");}?> disabled hidden>Select a security question</option>
								<option <?php if($securityQuestion == 'primary school'){echo("selected");}?> value="primary school">What was the name of your elementary / primary school?</option>
								<option <?php if($securityQuestion == 'pets name'){echo("selected");}?> value="pets name">What was the name of your first pet?</option>
								<option <?php if($securityQuestion == 'favourite teacher'){echo("selected");}?> value="favourite teacher">What was the name of your favourite teacher?</option>
							</select>
						</div>
						<span class="text-danger"><?php echo $securityQuestionError; ?></span>
					</div>

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon"></span></span>
							<input type="text" name="securityAnswer" class="form-control" placeholder="Enter a memorable word (security question)" maxlength="50" value="<?php echo $securityAnswer; ?>" />
						</div>
						<span class="text-danger"><?php echo $securityAnswerError; ?></span>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
					</div>

					<div class="form-group">
						<hr />
					</div>

					<div class="form-group">
						<a href="index.php">Sign in Here...</a>
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
		var a = document.forms["registerForm"]["pass"].value;
		var b = document.forms["registerForm"]["pass_confirm"].value;

		if (a!=b){
			alert("Passwords do not match.");
			return false;
		}
	}
</script>