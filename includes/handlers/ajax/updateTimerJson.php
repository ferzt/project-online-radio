<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["songId"])){
//    echo "<script>console.log('here')</script>";
    $songId=$_POST["songId"];
    $timer=$_POST["currentTime"];
    $query = mysqli_query($con, "UPDATE ON_AIR SET timer= $timer WHERE songRef=$songId");
//    echo($query ? "true" : "false");
}

?>