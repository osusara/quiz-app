<?php
  session_start();
  require_once('../includes/connection.php');
  require_once('../includes/functions.php');

  $errors = array();
  $question_display = "";

  // check if user is logged in
  if(!isset($_SESSION['user_id'])){
    header('Location: ../index.php?user=no');
  }

  //generate random ids
  $i = 0;
  $random_question_numbers = array(NULL, NULL, NULL, NULL, NULL);

  while($i<5){
    srand((double)microtime()*100000);
    $num = rand(1, 5);
    $c = 0;

    for($j=0; $j<4; $j++){
      if($random_question_numbers[$j] == $num){
        $c++;
        break;
      }
    }

    if($c==0){
      $random_question_numbers[$i] = $num;
      $i++;
    }
  }

  foreach($random_question_numbers as $key => $value) {

    $i = 0;
    $random_answer_numbers = array(NULL, NULL, NULL, NULL, NULL);

    while($i<5){
      srand((double)microtime()*100000);
      $num = rand(1, 5);
      $c = 0;

      for($j=0; $j<4; $j++){
        if($random_answer_numbers[$j] == $num){
          $c++;
          break;
        }
      }

      if($c==0){
        $random_answer_numbers[$i] = $num;
        $i++;
      }
    }

    // get questions
    $query = "SELECT * FROM questions WHERE question_id = {$value} LIMIT 5";
    $questions = mysqli_query($connection, $query);

    $question = mysqli_fetch_assoc($questions);

      $question_display .= "<div class=\"col-md-5 col-sm-6 col-xs-12 mx-auto py-3\">";
      $question_display .= "<div class=\"card shadow\" style=\"height: 100%;\">";
      $question_display .= "<div class=\"card-body\">";
      $question_display .= "<h5 class=\"card-title\">{$question['question']}</h5>";
      $question_display .= "<div class=\"container\">";
      $question_display .= "<div class=\"row\">";

      foreach ($random_answer_numbers as $key => $value) {
        
        $question_display .= "<div class=\"col-mid-4 col-sm-6 col-xs-10\">";

        switch ($value) {
          case 1:
            $question_display .= "<input type=\"radio\" name=\"{$question['question_id']}\" value=\"{$question['a']}\">{$question['a']}<br>";
            break;

          case 2:
            $question_display .= "<input type=\"radio\" name=\"{$question['question_id']}\" value=\"{$question['b']}\">{$question['b']}<br>";
            break;

          case 3:
            $question_display .= "<input type=\"radio\" name=\"{$question['question_id']}\" value=\"{$question['c']}\">{$question['c']}<br>";
            break;

          case 4:
            $question_display .= "<input type=\"radio\" name=\"{$question['question_id']}\" value=\"{$question['d']}\">{$question['d']}<br>";
            break;

          case 5:
            $question_display .= "<input type=\"radio\" name=\"{$question['question_id']}\" value=\"{$question['e']}\">{$question['e']}<br>";
            break;
          
          default:
            $question_display .= "<span>Answer Error!</span>";
            break;
        }

        $question_display .= "</div>";
      }

      $question_display .= "</div>";
      $question_display .= "</div>";
      $question_display .= "</div>";
      $question_display .= "</div>";
      $question_display .= "</div>";
    
  }

  $marks = 0;

  // check if the form is submited
  if(isset($_POST['submit'])){

    // checking required fields
    $req_fields = array('1', '2', '3', '4', '5');
    foreach ($req_fields as $field) {
      if(empty($_POST[$field])){
        $errors[] = 'Question '.$field.' is required';
      }
    }

    $answer = "";

    if(empty($errors)){

      foreach ($random_answer_numbers as $key => $value) {

        $answer = $_POST[$value];

        $query = "SELECT * FROM questions WHERE question_id='{$value}' LIMIT 1";
        $questions = mysqli_query($connection, $query);

        $question = mysqli_fetch_assoc($questions);

        if($question['answer'] == $answer){
          $marks++;
        }

        $query = "UPDATE user SET marks={$marks} WHERE user_id={$_SESSION['user_id']}";
        $result = mysqli_query($connection, $query);

        verify_query($result);
      }

      header('Location: profile.php?quiz_submit=true');

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

          <h1 class="card-title text-center py-3">Complete the quiz</h1>
          <form class="form" action="quiz.php" method="post">
            <div class="row">
              <div class="col-md-4 col-sm-8 col-xs-10 mx-auto">
                <?php
                  if(isset($errors) && !empty($errors)){
                    display_errors($errors);
                  }
                ?>
              </div>
            </div>
            <div class="row">

              <?php echo $question_display; ?>

            </div>
            <div class="text-center py-3">
              <input class="btn btn-success" type="submit" name="submit" value="Submit">
            </div>
            <div class="text-center">
              <a class="btn btn-dark" href="profile.php">Cancel</a>
            </div>
          </form>

    </div>
</body>
</html>
<?php mysqli_close($connection) ?>