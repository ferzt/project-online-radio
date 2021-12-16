<?php
include("../../config.php");
include("../../classes/Query.php");
if(isset($_POST["songId"])){
    $songId=$_POST["songId"];
    $query = mysqli_query($con, "SELECT * FROM SONG WHERE songID='$songId'");
//    $queryFeatures = mysqli_query($con, "SELECT * FROM credit WHERE songCredit='$songId'");
//    $resultArrayFeatures = array();
//    if(mysqli_num_rows($queryFeatures)>0){
//        while($row=mysqli_fetch_array($queryFeatures)){
//            array_push($resultArrayFeatures,$row['artist']);
//        }     
//    } 
    $resultArray = mysqli_fetch_array($query);
//    $resultArray["feature"]=$resultArrayFeatures;
    $jsonArray = json_encode($resultArray);
    
    echo $jsonArray;
}

?>