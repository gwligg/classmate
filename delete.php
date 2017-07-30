<?php
    include('config.php');
    $dbcon = new mysqli($host, $username, $pass, $database);
    
    if (!$dbcon) {
          exit('Connect Error (' . mysqli_connect_errno() . ') '
          . mysqli_connect_error());
          } 

// confirm that the 'id' variable has been set
if (isset($_GET['cid']) && is_numeric($_GET['cid']))
{
// get the 'id' variable from the URL
$cid = $_GET['cid'];

// delete record from database
if ($stmt = $dbcon->prepare("DELETE FROM class WHERE ClassID = ? LIMIT 1"))
{
$stmt->bind_param("i",$cid);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$dbcon->close();

// redirect user after delete is successful
header("Location: admin.php");
}

if (isset($_GET['uid']) && is_numeric($_GET['uid']))
{
// get the 'id' variable from the URL
$uid = $_GET['uid'];

// delete record from database
if ($stmt = $dbcon->prepare("DELETE FROM user WHERE UserID = ? LIMIT 1"))
{
$stmt->bind_param("i",$uid);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$dbcon->close();

// redirect user after delete is successful
header("Location: admin.php?sort=uid#user");
}

if (isset($_GET['eid']) && is_numeric($_GET['eid']))
{
// get the 'id' variable from the URL
$eid = $_GET['eid'];

// delete record from database
if ($stmt = $dbcon->prepare("DELETE FROM userevent WHERE EventID = ? LIMIT 1"))
{
$stmt->bind_param("i",$eid);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$dbcon->close();

// redirect user after delete is successful
header("Location: timetable.php");
echo '<script type="text/javascript">alert("Succesfully deleted event!");</script>';
}

else
// if the 'id' variable isn't set, redirect the user
{
//header("Location: adminPage.php");
  echo "ERROR: could not prepare SQL statement.";
}

?>