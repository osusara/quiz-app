<?php
	session_start();
	require_once('includes/connection.php');
	require_once('includes/functions.php');

	$errors = array();
	$messege = '';
	$warning = '';
	$email = "";


    if(isset($_GET['logout'])){
        if($_GET['logout'] == true){
            $messege = 'Logged out successfully';
        }
    }

    if(isset($_GET['user'])){
        if($_GET['user'] == 'no'){
            $warning = 'You must login first';
        }
    }

    if(isset($_GET['user_add'])){
        if($_GET['user_add'] == true){
            $messege = 'User successfully registered';
        }
    }

	// check if the login button clicked
	if(isset($_POST['submit'])){


		// check if email and password entered
		if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1){
			$errors[] = 'Email cannot be empty';
		}

		if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1){
			$errors[] = 'Password cannot be empty';
		}

		if(empty($errors)){

			// sanitize and save values to variables
			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password); // encrypt the password

			// database query
			$query = "SELECT * FROM user WHERE email='{$email}' AND password='{$hashed_password}' LIMIT 1";
			$result = mysqli_query($connection, $query);

			// call the function to verify the qurey
			verify_query($result);

			// when query is success
			if(mysqli_num_rows($result) == 1){

				// valid user found
				$user = mysqli_fetch_assoc($result);
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['user_name'] = $user['name'];

				// redirect to quiz
				header('Location: pages/profile.php');
			}else{

				// email/password incorrect
				$errors[] = 'Email or Password is incorrect';
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

    <link rel="shortcut icon" href="fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <title>Quiz App</title>
</head>
<body style="background-image: linear-gradient(to top, lightgrey 0%, lightgrey 1%, #e0e0e0 26%, #efefef 48%, #d9d9d9 75%, #bcbcbc 100%); background-attachment: fixed;">
    <div class="container-fluid">
    	<div class="row" style="height: 640px;">
    		<div class="col-lg-4 col-md-6 col-sm-8 col-xs-10 mx-auto my-auto">
    			<div class="card shadow">
    				<div class="card-body">
    					<h3 class="card-title text-center py-3">Sign in</h3>
    					<div class="container">
    						<form class="form" action="index.php" method="post">
    							<?php
 					       			if(isset($errors) && !empty($errors)){
 					       				display_errors($errors);
 			    					}
   					     		?>
   					     		<?php
 					       			if(isset($messege) && !empty($messege)){
 					       				display_messege($messege);
 			    					}
   					     		?>
   					     		<?php
 					       			if(isset($warning) && !empty($warning)){
 					       				display_warning($warning);
 			    					}
   					     		?>
	    						<div class="form-group">
    								<input type="email" name="email" class="form-control text-center" placeholder="Email">
  								</div>
  								<div class="form-group">
    								<input type="password" name="password" class="form-control text-center" placeholder="Password">
  								</div>
  								<hr>
  								<div>
  									<input class="btn btn-success" type="submit" name="submit" value="Login">
  									<small class="float-right">Don't have an account? &nbsp;<a class="btn btn-dark" href="pages/registration.php">Sign up</a></small>
  								</div>
    						</form>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    	
    </div>
</body>
</html>
<?php mysqli_close($connection) ?>