<?php
	
	// clean user inputs 
	function clean_data($name){
		$value = trim($_POST[$name]);
		$value = htmlspecialchars($value, ENT_QUOTES);
		$value = mysql_real_escape_string($value);
		$value = strip_tags($value);

		return $value;
	}


	function validate($name, $value, $minsize, $format=false){
		global $error;
		if(empty($value)){
			$error = true;
			return "Please enter your {$name}";
		}
		else if(strlen($value) < $minsize){
			$error = true;
			return ucfirst("{$name} must have at least {$minsize} characters");
		}
		else if($format == true && !preg_match("/^[a-zA-Z ]+$/", $value)){
			$error = true;
			return "Field must contain alphabet or space characters";
		}
	}

	function validate_select($name, $value){
		global $error;
		if(empty($value)){
			$error = true;
			return "Please select a {$name}";
		}
	}

	function validate_email($value, $check_existence=false){
		global $error;
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)){
			$error = true;
			return "Please enter a valid email address.";
		} else if($check_existence == true){
			// check email exist or not
			$query = "SELECT email FROM users WHERE email='$value'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				return "Provided Email is already in use.";
			}
		}
	}

	function validate_email2($value, $current, $check_existence=false){
		global $error;
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)){
			$error = true;
			return "Please enter a valid email address.";
		} else if($check_existence == true){
			// check email exist or not
			if($value != $current) {
                $query = "SELECT email FROM users WHERE email='$value'";
                $result = mysql_query($query);
                $count = mysql_num_rows($result);
                if ($count != 0) {
                    $error = true;
                    return "Provided Email is already in use.";
                }
            }
		}
	}

?>

