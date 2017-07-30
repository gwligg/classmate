<?php
session_start();
include_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

if (!isset($_SESSION['userSession'])) {
 header("Location: login.php");
}

$sql = "SELECT * FROM userevent WHERE UserID=".$_SESSION['userSession'];

$result = mysqli_query($dbcon,$sql);

$response = array();

while($row = mysqli_fetch_array($result))
{


array_push($response,array("id"=>$row[0], "title"=>$row[1], "start"=>$row[2], "end"=>$row[3], 'description' => $row[4], "allDay"=>false, 'color' => '#bc3232'));


}


echo json_encode($response);

mysqli_close($dbcon);



?>
