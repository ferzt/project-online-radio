<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["currentTime"])){
    
    $currentTime=$_POST["currentTime"];
    $songToPlay = $_POST["songId"];
    
    $query = mysqli_query($con, "SELECT songRef FROM ON_AIR WHERE priority = 0");
    
    $currentPlayingSong = "";
    if(mysqli_num_rows($query) == 1){
        $currentPlayingSong = mysqli_fetch_array($query);
    }
    
    if($songToPlay != $currentPlayingSong["songRef"]) {
        $query = mysqli_query($con, "DELETE FROM ON_AIR WHERE priority = 0");    
    }
    
    $updateOnAirSong = mysqli_query($con, "UPDATE ON_AIR SET priority=0, timer='$currentTime' WHERE songRef=$songToPlay");

}