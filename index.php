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
.logInFrame{
 width:100%;
 height:100vh;
}

.logocon{
  width:40%;
  background:#0049B3;
  display:flex;
  flex-direction:column;
  justify-content:center;
  text-align:center;
  margin:0 auto;
  color:white;
}

.imgLogo{
  width:400px;
}
.formcon{
  width:60%;
 background:white;
  display:flex;
  flex-direction:column;
  justify-content:center;
  margin:0 auto;
  text-align:center;
}

.formInput{
  border:none;
  border-bottom: 2px solid #0049B3;
  width:25%;
  font-size: 1.125em;
}

.row{
  margin:1em 0;
}

.submitButton{
  background:none;
  border:none;
  text-transform:uppercase;
  font-family: 'Poppins', sans-serif;
  color:#0049B3;
  cursor: pointer;
  font-size:1em;
  letter-spacing: 2px;

}

.loginTitle{
  font-family: 'Poppins', sans-serif;
 
  font-size:3em;
  color:#0049B3;
  letter-spacing:5px;
  margin-bottom:2em;
}

.inputcon{
  
  margin:2em 0;
}

.wrongInput{
  color:red;
  font-family: 'Poppins', sans-serif;
}

.title{
  font-family: 'Poppins', sans-serif;
  
}

.logocon p{
  font-family: 'Poppins', sans-serif;
  letter-spacing:5px;
  margin-top:-10px;
}
</style>


</head>
<body>

<div class="logInFrame">

  <div class="logocon"><center>
       <img src="dist/img/logo.png" class="imgLogo" id="system-logo">
       <div class=""><h1 class="title">Camet - Candelaria Dental Clinic - Patient Management System</h1></div>
       <p>ADMIN</p></center>
  </div>

  <!-- /.login-logo -->
  <div class="formcon">

    <div class="">
      <p class="loginTitle">LOGIN</p>

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
       
          <input type="text" class="formInput" 
          placeholder="Username" id="user_name" name="user_name">

         
        </div>



        <div class="inputcon">
       
          <input type="password" class="formInput" 
          placeholder="Password" id="password" name="password">

        
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button name="login" type="submit" class="submitButton">Sign In</button>
          </div>
          <!-- /.col -->
        </div>


        <div class="row">
          
        </div>
      </form>

      
    </div>
    <!-- /.login-card-body -->
  </div>

</div>
<!-- /.login-box -->



</body>
</html>
