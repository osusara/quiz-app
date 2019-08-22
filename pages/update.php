<?php
	session_start();
	require_once('../includes/connection.php');
	require_once('../includes/functions.php');

    // check if user is logged in
    if(!isset($_SESSION['user_id'])){
        header('Location: ../index.php');
    }

	$errors = array();
	$name = "";
	$email = "";

    // get user information
    $query = "SELECT * FROM user WHERE user_id = {$_SESSION['user_id']} LIMIT 1";
    $result = mysqli_query($connection, $query);

    // calling the function to verify the query
    verify_query($result);

    $user = mysqli_fetch_assoc($result);
    $name = $user['name'];
    $email = $user['email'];

	// check if the update button clicked
	if(isset($_POST['submit'])){

        $name = $_POST['name'];
        $email = $_POST['email'];

		// checking required fields
		$req_fields = array('name', 'email', 'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

        // Checking max length
        $max_len_fields = array('name' => 45, 'email' => 45);
        $errors = array_merge($errors, check_max_len($max_len_fields));

		// check validity of email
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    	    $errors[] = 'Email is not valid';
    	}

        // Checking if email already exist
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $query = "SELECT * FROM user WHERE email = {$email} AND user_id != {$_SESSION['user_id']} LIMIT 1";

        $result_set = mysqli_query($connection, $query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                $errors[] = "Email is already exist";
            }
        }

        // verify the password
        $password = $_POST['password'];
        $hashed_password = sha1($password); // encrypt the password

        if($hashed_password != $user['password']){
            $errors[] = 'Current password incorrect';
        }

		if(empty($errors)){

			// sanitize and save values to variables
			$name = mysqli_real_escape_string($connection, $_POST['name']);
			$email = mysqli_real_escape_string($connection, $_POST['email']);

			// database query
			$query = "UPDATE user SET name='{$name}', email='{$email}' WHERE user_id={$_SESSION['user_id']} LIMIT 1";

            $result = mysqli_query($connection, $query);

            if($result){
                header('Location: profile.php?user_update=true');

            }else{
                $errors[] = 'Failed to update the user';
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
    					<form class="form" action="update.php" method="post">
    						<div class="container">
    							<?php
 				  					// Display errors
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
                                    <input type="password" name="password" class="form-control text-center" placeholder="Password Verification">
                                </div>
  								<hr>
  								<div>
  									<input class="btn btn-success" type="submit" name="submit" value="Update">
  									<small class="float-right">Nothing to change? &nbsp;<a class="btn btn-dark" href="profile.php">Back</a></small>
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