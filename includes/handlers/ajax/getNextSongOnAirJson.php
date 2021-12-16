<?php
include("../../config.php");
include("../../classes/Query.php");

$query = mysqli_query($con, "SELECT songRef, timer FROM ON_AIR WHERE priority = 0");
$songId = mysqli_fetch_array($query);
echo json_encode($songId);

?>