<?php 
include("../../config.php");
include("../../classes/Request.php");

if(isset($_POST["songId"])){
    
    //get data in request
    $songId = $_POST["songId"];
    $username = $_POST["userName"];
    $timer = $_POST["timer"];
    
    //get user id from username
    $query = mysqli_query($con, "SELECT userID FROM USERS WHERE username = '$username'");
    $userId;
    while($row = mysqli_fetch_array($query)){
        $userId = $row["userID"];
    }
    
    //check that song is not already requested
    $query = mysqli_query($con, "SELECT songRef FROM ON_AIR WHERE songRef = '$songId'");

    //update table with new song request
    if(mysqli_num_rows($query) == 0) {
        $query = mysqli_query($con, "INSERT INTO ON_AIR VALUES ($songId,$userId,10,'$timer',null)");
    }
    
    $result = json_encode($query);
    echo $result;
 
}



?>