<?php
/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("config.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($username = '', $fname ='', $sname = '', $admin = '', $error = '', $uid = '')

{
  if(isset($_GET['uid'])){

  $uid = $_GET['uid'];

}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?php if ($uid != '') { echo "Edit User"; } else { echo "New User"; } ?>
</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel='stylesheet' href='fullcalendar/fullcalendar.min.css' />
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
<form class="form-signin" action="" method="post">
<h2 class="form-signin-heading"><?php if ($uid != '') { echo "Edit User"; } else { echo "New User"; } ?></h2><hr />
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<div>

<?php 
include("config.php");  
$dbcon = new mysqli($host, $username, $pass, $database);
  if ($uid != '') { 

  
  $stmt = $dbcon->prepare("SELECT Username,Fname,Sname,Admin FROM user WHERE UserID=?");
  
  $stmt->bind_param("i", $uid);
  $stmt->execute();

  $stmt->bind_result($username, $fname, $sname, $admin);
  $stmt->fetch();



  ?>
<input type="hidden" name="id" value="<?php echo $uid; ?>" />
<p>User ID: <?php echo $uid; ?></p>
<?php } ?>


            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputUsername"> Username</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputUsername" id="inputUsername" value="<?php echo $username; ?>" required />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputFname"> First Name</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputFname" id="inputFname" value="<?php echo $fname; ?>" required />
              </div>
              </div>            
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputSname"> Surname</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputSname" id="inputSname" value="<?php echo $sname; ?>" required />
              </div>
            </div>            
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputAdmin"> Admin</label>
              <div class="col-sm-6">
                <select class="form-control" name="inputAdmin">
                  <option value="1"<?php if ($admin == 1) echo "selected"; ?>>Yes</option>
                  <option value="0"<?php if ($admin == 0) echo "selected"; ?>>No</option>
                </select>
              </div>
            </div>  
            <i>*All fields required</i>
            <span style="float: right">
            <a class="btn" href="admin.php?sort=uid#user">Cancel</a>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit" />   
            </span>

</div>
</form>
</div>
</div>
</body>
</html>

<?php }

$dbcon = new mysqli($host, $username, $pass, $database);

/*

EDIT RECORD

*/
// if the 'cid' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['uid']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'cid' in the URL is valid
if (is_numeric($_GET['uid']))
{
// get variables from the URL/form
$uid = $_GET['uid'];
$username = mysqli_real_escape_string($dbcon, $_POST['inputUsername']);
$fname = mysqli_real_escape_string($dbcon, $_POST['inputFname']);
$sname = mysqli_real_escape_string($dbcon, $_POST['inputSname']);
$admin = mysqli_real_escape_string($dbcon, $_POST['inputAdmin']);


if ($username == '' || $fname == '' || $sname == '' || $admin == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($username, $fname, $sname, $admin, $error, $uid);
}
else
{
// if everything is fine, update the record in the database

if ($stmt = $dbcon->prepare("UPDATE user SET Username = ?, Fname = ?, Sname = ?, Admin = ?
WHERE UserID=?;"))
{

$stmt->bind_param("sssii", $username, $fname, $sname, $admin, $uid);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
$error = "ERROR: could not prepare SQL statement.";
}

// redirect the user once the form is updated
header("Location: admin.php?sort=uid#user");
}
}
// if the 'cid' variable is not valid, show an error message
else
{
echo "Error!";
}
}
// if the form hasn't been submitted yet, get the info from the database and show the form
else
{
// make sure the 'cid' value is valid
if (is_numeric($_GET['uid']) && $_GET['uid'] > 0)
{
// get 'cid' from URL
$uid = $_GET['uid'];

// get the recod from the database
if($stmt = $dbcon->prepare("SELECT Username,Fname,Sname,Admin FROM user WHERE UserID=?"))
{
$stmt->bind_param("i", $uid);
$stmt->execute();

$stmt->bind_result($username, $fname, $sname, $admin);
$stmt->fetch();

// show the form
renderForm($username, $fname, $sname, $admin);

$stmt->close();
}
// show an error if the query has an error
else
{
echo "Error: could not prepare SQL statement";
}
}
// if the 'cid' value is not valid, redirect the user back to the view.php page
else
{
header("Location: admin.php?sort=uid#user");
}
}
}

// close the dbcon connection
$dbcon->close();
?>