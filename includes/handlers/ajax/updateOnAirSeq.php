<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["currentTime"])){
    
    $currentTime=$_POST["currentTime"];
    
    $query = mysqli_query($con, "DELETE FROM ON_AIR WHERE priority = 0");
    
    $nextSongQuery = mysqli_query($con, "SELECT songRef FROM ON_AIR WHERE priority=1 ORDER BY timer LIMIT 1");
    $nextSong = mysqli_fetch_array($nextSongQuery);
    $nextSongRef = $nextSong["songRef"];
    
    $updateOnAirSong = mysqli_query($con, "UPDATE ON_AIR SET priority=0, timer='$currentTime' WHERE songRef=$nextSongRef");

}