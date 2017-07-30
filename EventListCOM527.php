<?php

include_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

$sql = "SELECT class.ClassID, class.ModuleCode, class.Type, class.Room, class.StartTime, class.EndTime, class.DayOfWeek, class.StartDate, class.EndDate, module.ModuleTitle, Module.ModuleLecturer FROM class INNER JOIN module ON class.ModuleCode = module.ModuleCode WHERE class.ModuleCode='COM527'";

$result = mysqli_query($dbcon,$sql);

$response = array();

while($row = mysqli_fetch_array($result))
{


array_push($response,array("id"=>$row[0], "title"=>$row[1] . ' ' . $row[2] . ' ' . $row[3], "start"=>$row[4], "end"=>$row[5], "dow"=>$row[6], "ranges"=>array( 0=>array( 'start'=>$row[7], "end"=>$row[8],)), "moduleCode"=>$row[1], "moduleName"=>$row[9], "moduleCode"=>$row[1], "classType"=>$row[2], "classRoom"=>$row[3], "lecturer"=> $row[10], "allDay"=>false));


}

echo json_encode($response);

mysqli_close($dbcon);



?>
