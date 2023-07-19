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
  <title>Barangay Anabu I-E | Patient Management System</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 
  <link rel="stylesheet" href="dist/css/style.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');



*{
  padding:0;
  margin:0;
}
body,html{
  background:#B92A30;
 position:relative;
 
}
.logInBackground{

background-repeat: no-repeat;
display: flex;
justify-content: center;

}

.loginCard{
  background:#2a246a;

  margin-top:13em;
 box-shadow: 0 3px 3px rgb(0,0,0,0.6);
}


.loginCardBackground{
  display: flex;
  padding:2em 4em;
  background:url('dist/img/logofade.png');
  background-size: cover;
}
.loginCardRow{
  width: 100%;
  padding:4em 2em;
}

.logoHolder{
  display: flex;
  margin-right: 3em;

}

.title{
  margin-top:4.5em;
}

.logoHolder p{
  font-family: 'Nunito', sans-serif;
  color:white;
  font-size: 10px;
  margin-bottom: -10px;
}
.logoHolder h3{
  font-family: 'Anton', sans-serif;
  
  text-transform: uppercase;
  letter-spacing:2px;
  font-size: 2em;
}

.formHolder{
  width:40%;
}


.formHolder h4{
  color:white;
  font-family: 'Nunito', sans-serif;
  font-size: 15px;
}
.loginCardRow img{
  margin-top:1em;
  height:120px;
 
  padding:1.5em;
}

.loginCardRow h3{
  color:white;
}

.inputcon{
  margin-bottom: 1em;
  margin-top:10px;
}

.inputcon input{
  font-size:17px;
  padding:10px;
}

.inputconButton{
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

.submitButton{
  background:#B92A30;
  border:none;
  padding:7px;
  text-transform: uppercase;
  color:white;
  font-weight: 900;
  font-family: 'Nunito', sans-serif;
  cursor:pointer;
}

.wrongInput{
  color:#B92A30;
  text-align: center;
  margin-bottom: 1em;
}
</style>


</head>
<body>

<div class="logInBackground">



<div class="loginCard">
<div class="loginCardBackground">


<div class="loginCardRow logoHolder">

  <img src="dist/img/logo2.png"> 
  <div class="title">
  <p>Barangay</p><h3>Anabu 1-E</h3>
  </div>
</div>


<div class="loginCardRow formHolder">
<h4>Login to your PMS</h4>
<form method="post">
     

        <div class="inputcon">       
          <input type="text" class="formInput" placeholder="Username" id="user_name" name="user_name">
        </div>

        <div class="inputcon">    
          <input type="password" class="formInput" placeholder="Password" id="password" name="password">      
          </div>
         <div class="col-md-12">
            <p class="wrongInput">
              <?php 
              if($message != '') {
                echo $message;
              }
              ?>
            </p>
      </div>

        <div class="inputconButton">
            <button name="login" type="submit" class="submitButton">Sign In</button>

        </div>

</form>

</div>


</div>




</div>









</div>



</body>
</html>
