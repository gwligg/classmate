<?php
  include("config.php");
  $dbcon = new mysqli($host, $username, $pass, $database);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
  $eventtitle=mysqli_real_escape_string($dbcon, $_POST['userEventName']);
  $datestart=mysqli_real_escape_string($dbcon, $_POST['dateStart']);
  $timestart=mysqli_real_escape_string($dbcon, $_POST['timeStart']);
  $dateend=mysqli_real_escape_string($dbcon, $_POST['dateEnd']);
  $timeend=mysqli_real_escape_string($dbcon, $_POST['timeEnd']);
  $eventdescription=mysqli_real_escape_string($dbcon, $_POST['userEventDescription']);
  $uid=mysqli_real_escape_string($dbcon, $_POST['userEventUid']);

  $eventstart = $datestart .' '. $timestart;
  $eventend = $dateend .' '. $timeend;

  $sql="INSERT INTO userevent(Title,EventStart,EventEnd,Description,UserID)VALUES
                                      ('$eventtitle','$eventstart','$eventend','$eventdescription','$uid')";


  if (!mysqli_query($dbcon,$sql)) {
  die('Error: ' . mysqli_error($dbcon));
}
      header('Location:timetable.php');
      echo '<script language="javascript">';
      echo 'alert("Event added!")';
      echo '</script>';

mysqli_close($dbcon);
?>                                    
