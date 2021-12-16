<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["artistId"])){
    $artistId=$_POST["artistId"];
    $query = mysqli_query($con, "SELECT * FROM CREDIT WHERE songCredit='$artistId'");
    $artistNames = array();
    while($row = mysqli_fetch_array($query)){
        $artistID = $row["artistCredit"];
        $artistQuery = mysqli_query($con, "SELECT stageName FROM ARTIST WHERE artistID='$artistID'");
        while($rowA = mysqli_fetch_array($artistQuery)){
            array_push($artistNames, $rowA['stageName']);
        }
    }
//    $resultArray = mysqli_fetch_array($query);
    $jsonArray = json_encode($artistNames);
    echo $jsonArray;
}

?>