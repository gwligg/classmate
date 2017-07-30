<?php

include("config.php");

function renderForm($title = '', $startdate = '', $enddate = '', $error = '', $hid = '')

{
  if(isset($_GET['hid'])){

  $hid = $_GET['hid'];

}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?php if ($hid != '') { echo "Edit Holiday"; } else { echo "New Holiday"; } ?>
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
<h2 class="form-signin-heading"><?php if ($hid != '') { echo "Edit Holiday"; } else { echo "New Holiday"; } ?></h2><hr />
<?php if ($error != '') {
echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
. "</div>";
} ?>

<div>

<?php 
include("config.php");  
$dbcon = new mysqli($host, $username, $pass, $database);
  if ($hid != '') { 

  
  $stmt = $dbcon->prepare("SELECT HolidayTitle, StartDate, EndDate FROM holiday WHERE HolidayID=?");
  
  $stmt->bind_param("i", $hid);
  $stmt->execute();

  $stmt->bind_result($title, $startdate, $enddate);
  $stmt->fetch();



  ?>
<input type="hidden" name="id" value="<?php echo $hid; ?>" />
<p>Holiday ID <?php echo $hid; ?></p>
<?php }  ?>
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputTitle"> Holiday Title</label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputTitle" id="inputTitle" value="<?php echo $title; ?>" required />
              </div>
            </div>                       
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputStartDate">Start Date  <input class="help-btn" id="startdate-help-btn" type="button" value="info"></label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="inputStartDate" placeholder="YYYY-MM-DD" id="inputStartDate" value="<?php echo $startdate; ?>" required />
              </div>
            </div>
        <div id="Dates" class="alert alert-info row">
           <a href="#" class="close" onclick="$('.alert').hide()" aria-label="close">&times;</a>
           <br>
           <div class="col-sm-6">
    <b> Semester 1 </b><br>
       <i><b>weekNo:  Start  - End </b></i>
       <p> W1: 2016-09-26 - 2016-10-01 <br>
        W2: 2016-10-03 - 2016-10-08 <br>
        W3: 2016-10-10 - 2016-10-14 <br>
        W4: 2016-10-17 - 2016-10-22 <br>
        W5: 2016-10-24 - 2016-10-29 <br>
        W6: 2016-10-31 - 2016-11-05 <br>
        W7: 2016-11-07 - 2016-11-12 <br>
        W8: 2016-11-14 - 2016-11-19 <br>
        W9: 2016-11-21 - 2016-11-26 <br>
        W10: 2016-11-28 - 2016-12-03 <br>
        W11: 2016-12-05 - 2016-12-10 <br>
        W12: 2016-12-12 - 2016-12-17 <br> </p>
        <br>
        </div>
        <div class="col-sm-6">
    <b> Semester 2 </b><br>
       <i><b>weekNo:  Start  - End </b></i>
       <p> W1: 2017-01-30 - 2017-02-04<br>
          W2: 2017-02-06 - 2017-02-11<br>
          W3: 2017-02-13 - 2017-02-18<br>
          W4: 2017-02-20 - 2017-02-25<br>
          W5: 2017-02-27 - 2017-03-04<br>
          W6: 2017-03-06 - 2017-03-11<br>
          W7: 2017-03-13 - 2017-03-18<br>
          W8: 2017-03-20 - 2017-03-25<br>
          W9: 2017-03-27 - 2017-04-01<br>
          W10: 2017-04-03 - 2017-04-08<br>
          W13: 2017-04-24 - 2017-04-29<br>
          W14: 2017-05-01 - 2017-05-06</p>
          </div>                 
    </div>             
            <div class="form-group row">
              <label class="col-sm-6 control-label" for="inputEndDate">End Date <input class="help-btn" id="enddate-help-btn" type="button" value="info"></label>
              <div class="col-sm-6">
               <input type="text" class="form-control" name="inputEndDate" placeholder="YYYY-MM-DD"  id="inputEndDate" value="<?php echo $enddate; ?>" required  />
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


    $(document).ready(function(){
      var start=$('input[name="inputStartDate"]');
      var end=$('input[name="inputEndDate"]'); 
      var options={
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
      };
      start.datepicker(options);
      end.datepicker(options);
    })

$("#inputEndDate").change(function () {
    var startDate = document.getElementById("inputStartDate").value;
    var endDate = document.getElementById("inputEndDate").value;
 
    if ((Date.parse(startDate) >= Date.parse(endDate))) {
        alert("End date must be later than class start date!"); 
        document.getElementById("inputEndDate").value = "";
    }
});

$(document).ready(function(){ 
  
  $('.help-btn').click(function(){
  
    $('#Dates').show()
  }) 
});


</script>   
</body>
</html>

<?php }

$dbcon = new mysqli($host, $username, $pass, $database);

/********************
Editing a records
*********************/
if (isset($_GET['hid']))
{

if (isset($_POST['submit']))
{

if (is_numeric($_GET['hid']))
{
// get variables from cid in the URL
$hid = $_GET['hid'];
$title = mysqli_real_escape_string($dbcon, $_POST['inputTitle']);
$startdate = mysqli_real_escape_string($dbcon, $_POST['inputStartDate']);
$enddate = mysqli_real_escape_string($dbcon, $_POST['inputEndDate']);



// check fields are not empty
if ($title == '' || $startdate == '' || $enddate == '')
{
// if any empty, show an error message
$error = 'ERROR: Please fill in all required fields!';
renderForm($title, $startdate, $enddate, $error, $hid);
}

else
{
// update db record with new information

if ($stmt = $dbcon->prepare("UPDATE holiday SET HolidayTitle = ?, StartDate = ?, EndDate = ?
WHERE HolidayID=?;"))
{

$stmt->bind_param("sssi", $title, $startdate, $enddate, $hid);
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
if (is_numeric($_GET['hid']) && $_GET['hid'] > 0)
{
// get cid from URL
$hid = $_GET['hid'];

// fetch record from db
if($stmt = $dbcon->prepare("SELECT HolidayTitle, StartDate, EndDate FROM holiday WHERE HolidayID=?"))
{
$stmt->bind_param("i", $hid);
$stmt->execute();

$stmt->bind_result($title, $startdate, $enddate);
$stmt->fetch();

// show the form
renderForm($title, $startdate, $enddate);

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
$title = mysqli_real_escape_string($dbcon, $_POST['inputTitle']);
$startdate = mysqli_real_escape_string($dbcon, $_POST['inputStartDate']);
$enddate = mysqli_real_escape_string($dbcon, $_POST['inputEndDate']);

// check no fields are empty
if ($title == '' || $startdate == '' || $enddate == '')
{
// if any empty, show an error message
$error = 'ERROR: Please fill in all required fields!';
renderForm($title, $startdate, $enddate, $error, $hid);
}
else
{
// insert the new record into the db
if ($stmt = $dbcon->prepare("INSERT INTO holiday(HolidayTitle,StartDate,EndDate)VALUES
                                      (?,?,?)"))
{
$stmt->bind_param("sss", $title, $startdate, $enddate);
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