<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: profile.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		
		// clean user inputs to prevent sql injections
		$firstName = trim($_POST['firstName']);
		$firstName = strip_tags($firstName);
		$firstName = htmlspecialchars($firstName);
        
        $surname = trim($_POST['surname']);
		$surname = strip_tags($surname);
		$surname = htmlspecialchars($surname);
        
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
        
        $gender = trim($_POST['gender']);
		$gender = strip_tags($gender);
		$gender = htmlspecialchars($gender);
		
        $city = trim($_POST['city']);
		$city = strip_tags($city);
		$city = htmlspecialchars($city);
        
        $country = trim($_POST['country']);
		$country = strip_tags($country);
		$country = htmlspecialchars($country);
        
        $birthday = trim($_POST['birthday']);
		$birthday = strip_tags($birthday);
		$birthday = htmlspecialchars($birthday);  

		$securityQuestion = trim($_POST['securityQuestion']);      
        
		$securityAnswer = trim($_POST['securityAnswer']);
		$securityAnswer = strip_tags($securityAnswer);
		$securityAnswer = htmlspecialchars($securityAnswer);
		
		// basic name validation
		if (empty($firstName)) {
			$error = true;
			$firstNameError = "Please enter your first name.";
		} else if (strlen($firstName) < 2) {
			$error = true;
			$firstNameError = "First name must have atleat 2 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$firstName)) {
			$error = true;
			$firstNameError = "Must contain alphabets and space.";
		} 
        
        if (empty($surname)) {
			$error = true;
			$surnameError = "Please enter your surname.";
		} else if (strlen($surname) < 2) {
			$error = true;
			$surnameError = "Surname must have atleat 2 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$surname)) {
			$error = true;
			$surnameError = "Must contain alphabets and space.";
		} 
        
       if (empty($gender)) {
			$error = true;
			$genderError = "Please select a gender.";
		} 
        
        if (empty($birthday)) {
			$error = true;
			$birthdayError = "Please enter your birthday.";
		} else if (strlen($birthday) < 2) {
			$error = true;
			$birthdayError = "Birthday must be the correct format (yyyy-mm-dd).";
		} 
        
        if (empty($city)) {
			$error = true;
			$cityError = "Please enter your city.";
		} else if (strlen($city) < 2) {
			$error = true;
			$cityError = "City must have atleat 2 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$city)) {
			$error = true;
			$cityError = "Must contain alphabets and space.";
		} 
        
        if (empty($country)) {
			$error = true;
			$countryError = "Please enter your country.";
		} else if (strlen($country) < 2) {
			$error = true;
			$countryError = "Country must have atleat 4 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$country)) {
			$error = true;
			$countryError = "Must contain alphabets and space.";
		} 

		if (empty($securityQuestion)) {
			$error = true;
			$securityQuestionError = "Please select a security question.";
		} 
        
		if (empty($securityAnswer)) {
			$error = true;
			$securityAnswerError = "Please enter your memorable word.";
		} else if (strlen($securityAnswer) < 3) {
			$error = true;
			$securityAnswerError = "Must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$securityAnswer)) {
			$error = true;
			$securityAnswerError = "Must contain alphabets and space.";
		} 
		
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM users WHERE email='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		
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
            
			$res = mysql_query($query) or die(mysql_error());;
				
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