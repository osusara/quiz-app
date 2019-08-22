<?php
	session_start();
	require_once('../includes/connection.php');
	require_once('../includes/functions.php');

	$errors = array();
	$name = "";
	$email = "";

	// check if the login button clicked
	if(isset($_POST['submit'])){

		// checking required fields
		$req_fields = array('name', 'email', 'password', 'confirm_password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// check validity of email
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    	    $errors[] = 'Email is not valid';
    	}

    	// Checking if email already exist
    	$email = mysqli_real_escape_string($connection, $_POST['email']); // Sanitizing email
    	$query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

    	$result = mysqli_query($connection, $query);

    	if($result){
    	    if(mysqli_num_rows($result) == 1){
    	        $errors[] = 'Email is already exist';
    	    }
    	}

    	// Cheking the password confirmation
    	if($_POST['password'] != $_POST['confirm_password']){
    		$errors[] = "Password is not match with the confirmation";
    	}

		if(empty($errors)){

			// sanitize and save values to variables
			$name = mysqli_real_escape_string($connection, $_POST['name']);
			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password); // encrypt the password

			// database query
			$query = "INSERT INTO user (name, email, password, marks) VALUES ('{$name}', '{$email}', '{$hashed_password}', 0)";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: ../index.php?user_add=true');
            }else{
                $errors[] = 'Failed to add the new record';
            }
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="../fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

    <title>Quiz App</title>
</head>
<body style="background-image: linear-gradient(to top, lightgrey 0%, lightgrey 1%, #e0e0e0 26%, #efefef 48%, #d9d9d9 75%, #bcbcbc 100%); background-attachment: fixed;">
    <div class="container-fluid">
    	<div class="row" style="height: 640px;">
    		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-10 mx-auto my-auto">
    			<div class="card shadow">
    				<div class="card-body">
    					<form class="form" action="registration.php" method="post">
    						<div class="container">
    							<?php
 					       			if(isset($errors) && !empty($errors)){
 					       				display_errors($errors);
 			    					}
   					     		?>
    							<div class="form-group">
 		   							<input type="text" name="name" class="form-control text-center" placeholder="Name" <?php echo 'value="'.$name.'"' ?>>
	  							</div>
    							<div class="form-group">
    								<input type="email" name="email" class="form-control text-center" placeholder="Email" <?php echo 'value="'.$email.'"' ?>>
  								</div>
  								<div class="form-group">
    								<input type="password" name="password" class="form-control text-center" placeholder="New Password">
  								</div>
  								<div class="form-group">
    								<input type="password" name="confirm_password" class="form-control text-center" placeholder="Re-enter the Password">
	  							</div>
  								<hr>
  								<div>
  									<input class="btn btn-success" type="submit" name="submit" value="Sign up">
  									<small class="float-right">Already have an account? &nbsp;<a class="btn btn-dark" href="../index.php">Login</a></small>
  								</div>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
    	
    </div>
</body>
</html>
<?php mysqli_close($connection) ?>