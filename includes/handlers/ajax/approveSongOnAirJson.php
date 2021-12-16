<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["songId"])){
    
    $songId=$_POST["songId"];
    $currentTime=$_POST["currentTime"];
    $approvedBy=$_POST["approvedBy"];
    
    $query = mysqli_query($con, "UPDATE ON_AIR SET priority=1, timer='$currentTime', approvedBy=$approvedBy WHERE songRef='$songId'");
    
    echo json_encode($query);
}