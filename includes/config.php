<?php
    ob_start();
    session_start();

    $timeZone = date_default_timezone_set("America/New_York");
//    $con = mysqli_connect("localhost","root","","radiotest");
    $con = mysqli_connect("us-cdbr-east-04.cleardb.com","b3b579187bfa74","2ea318fb","heroku_06e2a67321279c2");

    
    if(mysqli_connect_errno()) {
        echo "Failed to Connect: " . mysqli_connect_errno();
    }

?>