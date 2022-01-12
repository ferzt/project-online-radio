<?php
    include("dotenvParser.php");
    ob_start();
    session_start();

    $timeZone = date_default_timezone_set("America/New_York");

    (new DotEnv(__DIR__ . '/.env'))->load();

    $host = getenv('MYSQL_HOST');

    $user = getenv('MYSQL_USER');
        
    $pass = getenv('MYSQL_PASS');

    $datab = getenv('MYSQL_DAT');

    $con = mysqli_connect($host,$user,$pass,$datab);

    
    if(mysqli_connect_errno()) {
        echo "Failed to Connect: " . mysqli_connect_errno();
    }

?>