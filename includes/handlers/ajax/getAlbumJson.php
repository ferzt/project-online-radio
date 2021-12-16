<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["albumId"])){
    $songId=$_POST["albumId"];
    $query = mysqli_query($con, "SELECT * FROM ALBUM_INCLUSION WHERE songAlbum='$songId'");
    $albumIncl = mysqli_fetch_array($query);
    $albumFromSong = $albumIncl["album"];
    $albumQuery = mysqli_query($con, "SELECT * FROM ALBUM WHERE albumID='$albumFromSong'");
    $resultArray = mysqli_fetch_array($albumQuery);
    $jsonArray = json_encode($resultArray);
    echo $jsonArray;
}