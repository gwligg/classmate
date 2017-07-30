<?php
session_start();
require_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

if (isset($_SESSION['userSession'])!="") {
 header("Location: timetable.php");
 exit;
}

if (isset($_POST['btn-login'])) {
 
 $username = strip_tags($_POST['Username']);
 $password = strip_tags($_POST['Passwd']);
 
 $username = $dbcon->real_escape_string($username);
 $password = $dbcon->real_escape_string($password);
 
 $query = $dbcon->query("SELECT UserID, Username, Passwd FROM user WHERE Username='$username'");
 $row=$query->fetch_array();
 
 $count = $query->num_rows; // if username/password are correct returns must be 1 row
 
 if (password_verify($password, $row['Passwd']) && $count==1) {
  $_SESSION['userSession'] = $row['UserID'];
  header("Location: admin.php");
 } else {
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password!
    </div>";
 }
 $dbcon->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel='stylesheet' href='css/styles.css' />
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
</head>
<body>
    <div id="pageBanner">
      <img id="bannerLogo" src="images/UULogo.png">
      <div id="bannerText"><h1> Class Mate </h1></div>
    </div>

<div class="signin-form">

 <div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">Sign in to customise your timetable!</h2><hr />
        
        <?php
  if(isset($msg)){
   echo $msg;
  }
  ?>
        
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="Username" required />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="Passwd" required />
        </div>
       
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
   </button> 
            
    <a href="register.php" class="btn btn-default" style="float:right;">Or Register Here</a>
            
        </div>  
        
        
      
      </form>

    </div>
    
</div>

</body>
</html>