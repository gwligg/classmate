<?php
session_start();
include_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

$sql = "SELECT * FROM holiday";

$result = mysqli_query($dbcon,$sql);

$response = array();

while($row = mysqli_fetch_array($result))
{


array_push($response,array("id"=>$row[0], "title"=>$row[1], "start"=>"09:15", "end"=>"18:15", "ranges"=>array( 0=>array( 'start'=>$row[2], "end"=>$row[3],)),  'description' => "University closed- No classes", "allDay"=>false, 'color' => '#b4a168', 'holiday' => true));

}

echo json_encode($response);

mysqli_close($dbcon);



?>

