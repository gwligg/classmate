<?php

include("config.php");

function renderForm($modulecode = '', $title ='', $lecturer = '', $year = '', $error = '', $mid = '')

{
  if(isset($_GET['mid'])){

  $cid = $_GET['mid'];

}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?php if ($mid != '') { echo "Edit Module"; } else { echo "New Module"; } ?>
</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel='stylesheet' href='css/styles.css' />
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
<script src='fullcalendar/lib/jquery.min.js'></script>
<link rel='stylesheet' href='css/jquery.timepicker.css' />
<script src='scripts/jquery.timepicker.min.js'></script>
<script src='scripts/datepair.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
</head>
<body>
    <div id="pageBanner">
      <img id="bannerLogo" src="images/UULogo.png">
      <div id="bannerText"><h1> Class Mate </h1></div>
    </div>   
<div class="signin-form">

 <div class="container">
<form class="form-signin" action="" method="post">
<h2 class="form-signin-heading"><?php if ($mid != '') { echo "Edit Module"; } else { echo "New Module"; } ?></h2><hr />
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<div>

<?php 
include("config.php");  
$dbcon = new mysqli($host, $username, $pass, $database);
  if ($mid != '') { 

  
  $stmt = $dbcon->prepare("SELECT ModuleCode,ModuleTitle,ModuleLecturer,Year FROM module WHERE ModuleID=?");
  
  $stmt->bind_param("i", $mid);
  $stmt->execute();

  $stmt->bind_result($modulecode, $title, $lecturer, $year);
  $stmt->fetch();



  ?>
<input type="hidden" name="id" value="<?php echo $cid; ?>" />
<p>Module ID <?php echo $mid; ?></p>
<?php }  ?>

            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputCode"> Module Code</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputCode" id="inputCode" value="<?php echo $modulecode; ?>" required />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputTitle"> Title</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo $title; ?>" required />
              </div>
              </div>            
            </div>
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputLecturer"> Lecturer</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputLecturer" id="inputLecturer" value="<?php echo $lecturer; ?>" required />
              </div>
              </div>
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputYear"> Year</label>
                <div class="col-sm-6">
                  <select class="form-control" name="inputYear">
                    <option value="1"<?php if ($year == 1) echo "selected"; ?>>1</option>
                    <option value="2"<?php if ($year == 2) echo "selected"; ?>>2</option>
                    <option value="4"<?php if ($year == 4) echo "selected"; ?>>4</option>
                  </select>
                </div>
            </div>                         

            <i>*All fields required</i>
            <span style="float: right">
              <a class="btn" href="admin.php">Cancel</a>
              <input class="btn btn-primary" type="submit" name="submit" value="Submit" /> 
            </span>
</div>
</form>
</div>
</div>
<script type="text/javascript">
</script>   
</body>
</html>

<?php }

$dbcon = new mysqli($host, $username, $pass, $database);

/********************
Editing a records
*********************/
if (isset($_GET['mid']))
{

if (isset($_POST['submit']))
{

if (is_numeric($_GET['mid']))
{
// get variables from cid in the URL
$mid = $_GET['mid'];
$modulecode = mysqli_real_escape_string($dbcon, $_POST['inputCode']);
$title = mysqli_real_escape_string($dbcon, $_POST['inputTitle']);
$lecturer = mysqli_real_escape_string($dbcon,$_POST['inputLecturer']);
$year = mysqli_real_escape_string($dbcon,$_POST['inputYear']);


// check fields are not empty
if ($modulecode == '' || $title == '' || $lecturer == '' || $year == '')
{
// if any empty, show an error message
$error = 'ERROR: Please fill in all required fields!';
renderForm($modulecode, $title, $lecturer, $year, $error, $mid);
}

else
{
// update db record with new information

if ($stmt = $dbcon->prepare("UPDATE module SET ModuleCode = ?, ModuleTitle = ?, ModuleLecturer = ?, Year = ?
WHERE ModuleID=?;"))
{

$stmt->bind_param("sssii", $modulecode, $title, $lecturer, $year, $mid);
$stmt->execute();
$stmt->close();
}
// show error if query failed
else
{
$error = "ERROR: could not prepare SQL statement.";
}

// redirect to admin page if operation successful
header("Location: admin.php");
}
}
// Error getting cid from URL show 
else
{
echo "Error with the class number you have selected!";
}
}

else
{
// make sure the 'cid' value is valid
if (is_numeric($_GET['mid']) && $_GET['mid'] > 0)
{
// get cid from URL
$mid = $_GET['mid'];

// fetch record from db
if($stmt = $dbcon->prepare("SELECT ModuleCode,ModuleTitle,ModuleLecturer,Year FROM module WHERE ModuleID=?"))
{
$stmt->bind_param("i", $mid);
$stmt->execute();

$stmt->bind_result($modulecode, $title, $lecturer, $year);
$stmt->fetch();

// show the form
renderForm($modulecode, $title, $lecturer, $year);

$stmt->close();
}
// error processing sql query
else
{
echo "Error: could not prepare SQL statement";
}
}

else
{
header("Location: admin.php");
}
}
}



/********************
adding a new records
*********************/

// if there is no cid in the url, create a new record
else
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// get the information added via the form
$modulecode = mysqli_real_escape_string($dbcon, $_POST['inputCode']);
$title = mysqli_real_escape_string($dbcon, $_POST['inputTitle']);
$lecturer = mysqli_real_escape_string($dbcon,$_POST['inputLecturer']);
$year = mysqli_real_escape_string($dbcon, $_POST['inputYear']);


// check no fields are empty
if ($modulecode == '' || $title == '' || $lecturer == '' || $year == '')
{
// if any empty, show an error message
$error = 'ERROR: Please fill in all required fields!';
renderForm($modulecode, $title, $lecturer, $year, $error, $mid);
}
else
{
// insert the new record into the db
if ($stmt = $dbcon->prepare("INSERT INTO module(ModuleCode,ModuleTitle,ModuleLecturer,Year)VALUES
                                      (?,?,?,?)"))
{
$stmt->bind_param("ssss", $modulecode, $title, $lecturer, $year);
$stmt->execute();
$stmt->close();
}
// error processing sql query
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirect to admin page if operation successful
header("Location: admin.php");
}

}
// show form if the submit button has not been clicked
else
{
renderForm();
}
}

// close db connection
$dbcon->close();
?>