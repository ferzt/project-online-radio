<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["playlistOrder"])){
    
    $playlistOrder = $_POST["playlistOrder"];
    $playlistID = $_POST["playlistID"];
  
    $i=1;
    $rearray = array();
    $squery;
    foreach($playlistOrder as $p) {

        $query = mysqli_query($con, "SELECT * FROM PLAYLIST_INCLUSION WHERE songInclusion=$p AND playlistInclusion = $playlistID");

        if(mysqli_num_rows($query) == 0) {

            $squery = mysqli_query($con, "INSERT INTO PLAYLIST_INCLUSION VALUES ($i, $playlistID, $p)"); 

            
            
        } else {

            $query = mysqli_query($con, "UPDATE PLAYLIST_INCLUSION SET playOrder=$i WHERE playlistInclusion = $playlistID AND songInclusion = $p");

        }
        $i++;
    }

}