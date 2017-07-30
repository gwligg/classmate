<?php
session_start();
include_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
}
$query = $dbcon->query("SELECT * FROM user WHERE UserID=".$_SESSION['userSession']);
$userRow=$query->fetch_array();

if($userRow['Admin'] == '0'){
  header("Location: timetable.php");

}

$dbcon->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Controls</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel='stylesheet' href='css/jquery.timepicker.css' />
<link rel='stylesheet' href='css/styles.css' />
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='scripts/jquery.timepicker.min.js'></script>
<script src='scripts/bootstrap-datepicker.js'></script>
<script src='scripts/datepair.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container" id="pageContainer">
    <div id="pageBanner">
      <img id="bannerLogo" src="images/UULogo.png">
      <div id="bannerText"><h1> Class Mate </h1></div> 
    </div>
    <div id="loginNav">
<p> Welcome, <?php echo $userRow['Fname']; ?>! <a href="logout.php?logout">Logout</a></p>
</div>
<div class="adminFunction">
<a href="timetable.php"><button id="TimetableButton" class="btn-xs btn-primary">View Timetable</button></a>
</div>
<br>
<br>
<br>  

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#classesTab">Classes</a></li>
  <li><a data-toggle="tab" href="#userTab">Users</a></li>
  <li><a data-toggle="tab" href="#moduleTab">Modules</a></li>
  <li><a data-toggle="tab" href="#holidayTab">Holidays</a></li>
</ul>

<div class="tab-content">
  <div id="classesTab" class="tab-pane fade in active">
  <div id="modifyClasses">
    <h3>Classes</h3>
    <a href="records.php"><button class="btn-xs btn-default add-btn">Add new class</button></a>
  <br>
    <div class="" id="display">
<?php
    include('config.php');
    $dbcon = new mysqli($host, $username, $pass, $database);
    
    if (!$dbcon) {
          exit('Connect Error (' . mysqli_connect_errno() . ') '
          . mysqli_connect_error());
          } 



  
  $stmt = "SELECT * FROM class";

    $query_sort_classes = (isset($_GET['sort']) ? $_GET['sort'] : null);

        if ($query_sort_classes == 'ModuleCode')
{
    $stmt .= " ORDER BY ModuleCode";
}
elseif ($query_sort_classes == 'Type')
{
    $stmt .= " ORDER BY Type";
}
elseif ($query_sort_classes == 'Room')
{
    $stmt .= " ORDER BY Room";
}
elseif($query_sort_classes == 'StartTime')
{
    $stmt .= " ORDER BY StartTime";
}
elseif($query_sort_classes == 'EndTime')
{
    $stmt .= " ORDER BY EndTime";
}
elseif ($query_sort_classes == 'Dow')
{
    $stmt .= " ORDER BY DayOfWeek";
}
elseif($query_sort_classes == 'StartDate')
{
    $stmt .= " ORDER BY StartDate";
}
elseif($query_sort_classes == 'EndDate')
{
    $stmt .= " ORDER BY EndDate";
}
elseif($query_sort_classes == 'cid')
{
    $stmt .= " ORDER BY ClassID";
}

  $dbcon = mysqli_query($dbcon, $stmt);
  ?>

<table class='table table-responsive recordListTable'>

 <tr>
     <th><a href='admin.php?sort=cid#classes'>ID</a></th>
     <th><a href='admin.php?sort=ModuleCode#classes'>Module Code</a></th> 
     <th><a href='admin.php?sort=Type#classes'>Type</a></th>
     <th><a href='admin.php?sort=Room#classes'>Room</a></th>
     <th><a href='admin.php?sort=StartTime#classes'>Start Time</a></th>
     <th><a href='admin.php?sort=EndTime#classes'>End Time</a></th>
     <th><a href='admin.php?sort=Dow#classes'>Day</a></th>
     <th><a href='admin.php?sort=StartDate#classes'>Start Date</a></th>
     <th><a href='admin.php?sort=EndDate#classes'>End Date</a></th>
     <th></th>
     <th></th>
</tr>

<?php

  while ( $row=mysqli_fetch_assoc($dbcon)) {

    if ($row['DayOfWeek'] == '1'){

  $row['DayOfWeek'] = 'Monday';
}if ($row['DayOfWeek'] == '2'){

  $row['DayOfWeek'] = 'Tuesday';
}if ($row['DayOfWeek'] == '3'){

  $row['DayOfWeek'] = 'Wednesday';
}if ($row['DayOfWeek'] == '4'){

  $row['DayOfWeek'] = 'Thursday';
}if ($row['DayOfWeek'] == '5'){

  $row['DayOfWeek'] = 'Friday';
}

echo "<tr>";

echo '<td>' . $row['ClassID'] . '</td>';

echo '<td>' . $row['ModuleCode'] . '</td>';

echo '<td>' . $row['Type'] . '</td>';

echo '<td>' . $row['Room'] . '</td>';

echo '<td>' . $row['StartTime'] . '</td>';

echo '<td>' . $row['EndTime'] . '</td>';

echo '<td>' . $row['DayOfWeek'] . '</td>';

echo '<td>' . $row['StartDate'] . '</td>';

echo '<td>' . $row['EndDate'] . '</td>';

echo "<td><a href='records.php?cid=" . $row['ClassID'] . "'>Edit</a></td>";
echo "<td><a href='delete.php?cid=" . $row['ClassID'] . "'>Delete</a></td>";

echo "</tr>";

}// close table>


echo "</table>";
?>


    </div>

    </div>
    </div>




  <div id="userTab" class="tab-pane fade">
    <h3>Users</h3>
    <div class="" id="displayUsers">    
<?php
    include('config.php');
    $dbcon = new mysqli($host, $username, $pass, $database);
    
    if (!$dbcon) {
          exit('Connect Error (' . mysqli_connect_errno() . ') '
          . mysqli_connect_error());
          } 
  
  $stmt = "SELECT UserID, Username, Fname, Sname, Admin FROM user";

      $query_sort_users = (isset($_GET['sort']) ? $_GET['sort'] : null);

        if ($query_sort_users == 'uid')
{
    $stmt .= " ORDER BY UserID";
}
elseif ($query_sort_users == 'Username')
{
    $stmt .= " ORDER BY Username";
}
elseif ($query_sort_users == 'Fname')
{
    $stmt .= " ORDER BY Fname";
}
elseif($query_sort_users == 'Sname')
{
    $stmt .= " ORDER BY Sname";
}
elseif($query_sort_users == 'Admin')
{
    $stmt .= " ORDER BY Admin DESC";
}

  $dbcon = mysqli_query($dbcon, $stmt);
?>

  

 <table class='table table-responsive recordListTable'>
  <tr> 
     <th><a href='admin.php?sort=uid#user'>ID</a></th> 
     <th><a href='admin.php?sort=Username#user'>Username</a></th>
     <th><a href='admin.php?sort=Fname#user'>First Name</a></th>
     <th><a href='admin.php?sort=Sname#user'>Surname</a></th>
     <th><a href='admin.php?sort=Admin#user'>Admin</a></th>
     <th></th>
     <th></th>
</tr>

<?php


while ( $row=mysqli_fetch_assoc($dbcon)) {


  if ($row['Admin'] == '1')
  {
    $row['Admin'] = 'Yes';
  }
  if ($row['Admin'] == '0')
  {
    $row['Admin'] = 'No';
  }


echo "<tr>";

echo '<td>' . $row['UserID'] . '</td>';

echo '<td>' . $row['Username'] . '</td>';

echo '<td>' . $row['Fname'] . '</td>';

echo '<td>' . $row['Sname'] . '</td>';

echo '<td>' . $row['Admin'] . '</td>';

echo '<td><a href="userRecords.php?uid=' . $row['UserID'] . '">Edit</a></td>';

echo '<td><a href="delete.php?uid=' . $row['UserID'] . '">Delete</a></td>';

echo "</tr>";

}

?>
</table>

    </div>
</div>

  <div id="moduleTab" class="tab-pane fade">
    <h3>Modules</h3>
  <a href="moduleRecords.php"><button class="btn-xs btn-default add-btn">Add new module</button></a>
  <br>
    <div class="" id="displayModules">    
<?php
    include('config.php');
    $dbcon = new mysqli($host, $username, $pass, $database);
    
    if (!$dbcon) {
          exit('Connect Error (' . mysqli_connect_errno() . ') '
          . mysqli_connect_error());
          } 
  
  $stmt = "SELECT * FROM module";

      $query_sort_modules = (isset($_GET['sort']) ? $_GET['sort'] : null);

        if ($query_sort_modules == 'mid')
{
    $stmt .= " ORDER BY ModuleID";
}
elseif ($query_sort_modules == 'code')
{
    $stmt .= " ORDER BY ModuleCode";
}
elseif ($query_sort_modules == 'title')
{
    $stmt .= " ORDER BY ModuleTitle";
}
elseif ($query_sort_modules == 'lecturer')
{
    $stmt .= " ORDER BY ModuleLecturer";
}
elseif($query_sort_modules == 'year')
{
    $stmt .= " ORDER BY Year";
}

  $dbcon = mysqli_query($dbcon, $stmt);
?>

  

 <table class='table table-responsive recordListTable'>
  <tr> 
     <th><a href='admin.php?sort=mid#module'>ID</a></th>
     <th><a href='admin.php?sort=code#module'>Module Code</a></th> 
     <th><a href='admin.php?sort=title#module'>Title</a></th>
     <th><a href='admin.php?sort=lecturer#module'>Lecturer</a></th>
     <th><a href='admin.php?sort=year#module'>Year</a></th>
     <th></th>
     <th></th>
</tr>

<?php


while ( $row=mysqli_fetch_assoc($dbcon)) {


echo "<tr>";

echo '<td>' . $row['ModuleID'] . '</td>';

echo '<td>' . $row['ModuleCode'] . '</td>';

echo '<td>' . $row['ModuleTitle'] . '</td>';

echo '<td>' . $row['ModuleLecturer'] . '</td>';

echo '<td>' . $row['Year'] . '</td>';

echo '<td><a href="moduleRecords.php?mid=' . $row['ModuleID'] . '">Edit</a></td>';

echo '<td><a href="delete.php?mid=' . $row['ModuleID'] . '">Delete</a></td>';

echo "</tr>";

}

?>
</table>

    </div>
</div>

<div id="holidayTab" class="tab-pane fade">
    <h3>Holidays</h3>
  <a href="holidayRecords.php"><button class="btn-xs btn-default add-btn">Add new holiday</button></a>
  <br>
    <div class="" id="displayHolidays">    
<?php
    include('config.php');
    $dbcon = new mysqli($host, $username, $pass, $database);
    
    if (!$dbcon) {
          exit('Connect Error (' . mysqli_connect_errno() . ') '
          . mysqli_connect_error());
          } 
  
  $stmt = "SELECT * FROM holiday";

      $query_sort_holidays = (isset($_GET['sort']) ? $_GET['sort'] : null);

        if ($query_sort_holidays == 'hid')
{
    $stmt .= " ORDER BY HolidayID";
}
elseif ($query_sort_holidays == 'title')
{
    $stmt .= " ORDER BY HolidayTitle";
}
elseif ($query_sort_holidays == 'start')
{
    $stmt .= " ORDER BY StartDate";
}
elseif($query_sort_holidays == 'end')
{
    $stmt .= " ORDER BY EndDate";
}

  $dbcon = mysqli_query($dbcon, $stmt);
?>

  

 <table class='table table-responsive recordListTable'>
  <tr> 
     <th><a href='admin.php?sort=hid#holiday'>ID</a></th> 
     <th><a href='admin.php?sort=title#holiday'>Title</a></th>
     <th><a href='admin.php?sort=start#holiday'>Start</a></th>
     <th><a href='admin.php?sort=end#holiday'>End</a></th>
     <th></th>
     <th></th>
</tr>

<?php


while ( $row=mysqli_fetch_assoc($dbcon)) {


echo "<tr>";

echo '<td>' . $row['HolidayID'] . '</td>';

echo '<td>' . $row['HolidayTitle'] . '</td>';

echo '<td>' . $row['StartDate'] . '</td>';

echo '<td>' . $row['EndDate'] . '</td>';

echo '<td><a href="holidayRecords.php?hid=' . $row['HolidayID'] . '">Edit</a></td>';

echo '<td><a href="delete.php?hid=' . $row['HolidayID'] . '">Delete</a></td>';

echo "</tr>";

}

?>
</table>

    </div>
</div>     


        
</div>

<script type="text/javascript">

var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + 'Tab"]').tab('show');
}

$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})



</script>   
</body>
</html>
