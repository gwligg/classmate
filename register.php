<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
 header("Location: timetable.php");
}
require_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

if(isset($_POST['btn-signup'])) {
 
 $uname = strip_tags($_POST['Username']);
 $fname = strip_tags($_POST['Fname']);
 $sname = strip_tags($_POST['Sname']);
 $upass = strip_tags($_POST['Passwd']);
 
 $uname = $dbcon->real_escape_string($uname);
 $fname = $dbcon->real_escape_string($fname);
 $sname = $dbcon->real_escape_string($sname);
 $upass = $dbcon->real_escape_string($upass);

 
 $hashed_password = password_hash($upass, PASSWORD_DEFAULT); 
 
 $check_uname = $dbcon->query("SELECT Username FROM user WHERE Username='$uname'");
 $count=$check_uname->num_rows;
 
 if ($count==0) {
  
  $query = "INSERT INTO user(Username,Fname,Sname,Passwd) VALUES('$uname','$fname','$sname','$hashed_password')";

  if ($dbcon->query($query)) {
   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered!
     </div>";


  }else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering!
     </div>";
  }
  
 } else {
  
  
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry username already taken!
    </div>";
   
 }
 
 $dbcon->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel='stylesheet' href='css/styles.css' />
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
<title>Register Your account</title>


</head>
<body>
    <div id="pageBanner">
      <img id="bannerLogo" src="images/UULogo.png">
      <div id="bannerText"><h1> Class Mate </h1></div>
    </div>

<div class="signin-form">

 <div class="container">
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
  if (isset($msg)) {
   echo $msg;
  }
  ?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="Username" required  />
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" placeholder="First Name" name="Fname" required  />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="text" class="form-control" placeholder="Last Name" name="Sname" required  />
        <span id="check-e"></span>
        </div>

        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="Passwd" required  />
        </div>
        
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">Sign Up</button> 
            <a href="login.php" class="btn btn-default" style="float:right;">Or Log In Here</a>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>