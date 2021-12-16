<?php 
include("../config.php");
include("../classes/Request.php");

if(isset($_POST["playlistName"])){
    
    $result = array();
    
    $plname= $_POST["playlistName"];
    $plpublic= $_POST["public"];
    $userLoggedIn = $_POST["username"];
    
    $query = mysqli_query($con, "SELECT userID FROM USERS WHERE username = '$userLoggedIn'");
    $username = mysqli_fetch_array($query);
    $userId = $username["userID"];
    
    $result = array("userId"=>$userId);

    $query = mysqli_query($con, "INSERT INTO PLAYLIST (name, public, createdBy) VALUES ('$plname', $plpublic, $userId)");
    
    $query = mysqli_query($con, "SELECT playlistID FROM PLAYLIST WHERE name = '$plname' AND createdBy = $userId");
    
    
    $playlistId = mysqli_fetch_array($query);
    $playlistId = $playlistId["playlistID"];
    
    $result += array("playlistId"=>$playlistId);
    
    echo json_encode($result);

//    echo json_encode({"playlistId"=>$playlistId,"userId"=>$userId});
}


?>