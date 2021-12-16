<?php
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){
    include("includes/config.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Collection.php");
    include("includes/classes/Query.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");
    include("includes/classes/User.php");
}else{
    include("includes/header.php");
    include("includes/footer.php");
    
    $url = $_SERVER["REQUEST_URI"];
    echo "<script>openPage('$url');</script>";
    exit(); // Prevent from loading You May Also Like... twice
    
}

?>