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
    $marks = "";

	// get user information
    $query = "SELECT * FROM user WHERE user_id = {$_SESSION['user_id']} LIMIT 1";
    $result = mysqli_query($connection, $query);

    // Calling the function to verify the query
    verify_query($result);

    $user = mysqli_fetch_assoc($result);
    $name = $user['name'];
    $email = $user['email'];
    $marks = $user['marks'];
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
            <div class="col-md-4 col-sm-6 col-xs-8 mx-auto my-auto">
                <div class="container">
                    <div class="card text-center shadow py-3">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $name; ?></h3>
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <span class="text-light">Current marks</span>
                                    <h1 class="display-1 text-light"><?php echo $marks; ?></h1>
                                </div>
                            </div>
                            <hr>
                            <div class="text-left">
                                <a class="btn btn-success" href="quiz.php">Go to Quiz</a>
                                <span class="float-right">
                                    <a class="btn btn-dark" href="update.php">Edit user</a>
                                    <a class="btn btn-danger" href="logout.php">Logout</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php mysqli_close($connection) ?>