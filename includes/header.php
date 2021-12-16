<?php
include("includes/config.php");
include("includes/classes/Artist.php");
//include("includes/classes/Album.php");
include("includes/classes/Song.php");
include("includes/classes/Query.php");
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    $userType = $_SESSION['userType'];
    echo "<script> var userLoggedIn='$userLoggedIn'; var userPriv = '$userType'</script>";
} else {
    header("Location: index.php");
}    
?>

<html>
    <head>
        <link rel="stylesheet" href="assets/css/input.css">
        <link rel="stylesheet" href="assets/css/pop-up.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
        <script src="assets/js/script.js"></script>
        <script>
            $(document).ready(function(){
                $(".navItemLink:first").parent().addClass("activeLink");
            });
        </script>
        
        <title>Stream: Welcome <?php echo $userLoggedIn; ?></title>
    </head>
    
    <body>
        
        <div id="mainContainer">
            
            <div id="topContainer">
               <?php include("includes/navBarContainer.php")?>  
                <div id="mainViewContainer">
                    <div id=mainViewContent>