<?php 
	include './config/connection.php';

$message = '';

	if(isset($_POST['login'])) {
    $userName = $_POST['user_name'];
    $password = $_POST['password'];

    $encryptedPassword = md5($password);

    $query = "select `id`, `display_name`, `user_name`, 
`profile_picture` from `users` 
where `user_name` = '$userName' and 
`password` = '$encryptedPassword';";

try {
  $stmtLogin = $con->prepare($query);
  $stmtLogin->execute();

  $count = $stmtLogin->rowCount();
  if($count == 1) {
    $row = $stmtLogin->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user_id'] = $row['id'];
    $_SESSION['display_name'] = $row['display_name'];
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['profile_picture'] = $row['profile_picture'];

    header("location:dashboard.php");
    exit;

  } else {
    $message = 'Incorrect Credentials';
  }
}  catch(PDOException $ex) {
      echo $ex->getTraceAsString();
      echo $ex->getMessage();
      exit;
    }
  

		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Clinic's Patient Management System in PHP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 
  <link rel="stylesheet" href="dist/css/style.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

*{
  padding:0;
  margin:0;
}
body,html{
  background:#2b246a;
 position:relative;
}
.logInBackground{
 background: url('dist/img/logofade.png'); 
 background-size: cover;
 background-repeat: no-repeat;
 width: 100%;
 height: 100vh;
}
</style>


</head>
<body>

<div class="logInBackground">



<form method="post">
      <div class="col-md-12">
            <p class="wrongInput">
              <?php 
              if($message != '') {
                echo $message;
              }
              ?>
            </p>
      </div>

        <div class="inputcon">       
          <input type="text" class="formInput" placeholder="Username" id="user_name" name="user_name">
        </div>

        <div class="inputcon">    
          <input type="password" class="formInput" placeholder="Password" id="password" name="password">      
          </div>
        

        <div class="inputcon">
            <button name="login" type="submit" class="submitButton">Sign In</button>

        </div>

</form>



</div>



</body>
</html>
