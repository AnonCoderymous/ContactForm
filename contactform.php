<?php
	$message = 1;
	$message_condition = 1;
	$success = 0;
	$isNumber = 0;
	$emailInvalid = FALSE;
	if(isset($_POST[ 'name' ]) && $_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

		$servername = "localhost";
		$username = "root";
		$password = "";
		$db_name = "contactus";

		$name = trim($_POST[ 'name' ]);
		$email = trim($_POST[ 'email' ]);
		$number = trim($_POST[ 'number' ]);
		$message = trim($_POST[ 'message' ]);

		if(strlen($message) >= 50) {
			$message_condition = 0;
			$success = 1;
		}

		$con = new mysqli($servername, $username, $password, $db_name);

		if(!$con) {
			die("Connection to database failed ".$con->connect_error);
		}

		if(preg_match("/[0-9]/i", $number) == FALSE ) {
			$isNumber = 1;
			$success = 1;
		}

		if( !filter_var($email, FILTER_VALIDATE_EMAIL )) {
			$emailInvalid = TRUE;
			$success = 1;
		}

		$insert_query = "INSERT INTO `contactinfotable`(`name`, `email`, `number`, `message`) VALUES ('$name','$email','$number','$message')";

		if($success == 0 ) {
			$r = $con->query($insert_query);
		}

		$con->close();
	}
	// $con->free_result();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Us Form</title>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@600&display=swap');
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		.navbar {
			position: relative;
			width: 100%;
			text-align: inherit;
			padding: 0px 20px;
			background: linear-gradient(90deg, red, purple);
		}

		form {
			width: 200px;
			transform-style: preserve-3d;
			/*background: whitesmoke;*/
			margin: auto;
		}

		.navbar h3 {
			font-size: 25px;
			text-transform: capitalize;
			color: white;
			font-family: 'Roboto Mono', monospace;
			padding-top: 15px;
			padding-bottom: 15px;
		}

		.form-class {
			position: relative;
			top: 2rem;
		}

		.form-class form input {
			display: block;
			text-align: initial;
			padding: 5px;
			margin-bottom: 10px;
			outline: none;
			font-family: 'Roboto Mono', monospace;
			border-style: solid;
			border-color: black;
			border-width: 1px;
			font-size: 15px;
			width: 250px;
		}

		.form-class form input[type=submit] {
			width: 100px;
			text-align: center;
			background: navy;
			color: white;
			outline: none;
			opacity: 0.7;
		}

		.form-class form input[type=submit]:hover{
			opacity: 1;
			cursor: pointer;
		}

		.form-class form label {
			font-family: 'Roboto Mono', monospace;
		}

		#address {
			height: 5em;
			padding: 10px;
		}

		.success {
			padding: 10px;
			margin-left: 10px;
			font-weight: 600;
			background: linear-gradient(90deg, lightgreen, darkgreen);
			width: fit-content;
			color: white;
			border-radius: 10px;
		}
		
		.msgerror {
			padding: 10px;
			margin-left: 10px;
			font-weight: 600;
			background: linear-gradient(90deg, red, purple);
			width: fit-content;
			color: white;
			border-radius: 5px;
		}

		.isNumbererror {
			background: linear-gradient(100deg, red, purple);
			color: white;
			padding: 10px;
			font-weight: 600;
			margin-left: 10px;
			border-radius: 5px;
			width: fit-content;
		}

	</style>
</head>
<body>
	<div class="navbar">
		<h3>contact us</h3>
	</div>
	<div class="form-class">
			<form action="<?php echo $_SERVER[ 'PHP_SELF' ] ?>" method="POST" autocomplete="ON" align="center">
				<label>Enter your name</label>
				<input type="text" name="name" placeholder="" required>
				<label>Enter your email</label>
				<input type="text" name="email" placeholder="" required>
				<label>Enter your number</label>
				<input type="text" name="number" placeholder="" required>
				<label>Enter your message</label>
				<input type="text" name="message" placeholder="" required id="address">
				<input type="submit" name="submitBTN" value="Submit">
			</form>
		</div>
		<?php
			if($message_condition == 0 ) {
		?>

		<div class="msgerror">
			Your message is large. Make it shorter than 50 characters.
		</div>

		<?php
			}
		?>

		<?php 
		if($isNumber == 1) 
			{ 
		?> <div class="isNumbererror">
			You number is invalid.
		</div>
		<?php 
			}
		?>
		<?php
			if( $success == 0 ){
		?>
		<div class="success">
			Thank you for contacting us. We have received your message.
		</div>
		<?php
			}
		?>
		<?php
			if($emailInvalid == TRUE) {
		?>
		<div class="isNumbererror">
			Your email is Invalid. Please check your email.
		</div>
		<?php
			}
		?>	
	</body>
</body>
</html>