<?php
include("../config.php");
include("../classes/Artist.php");

if(isset($_FILES['artwork']) && isset($_FILES['music'])){
    
    $userArtist = $_POST["userArtist"];
    $songTitle = $_POST["title"];
    
    $artistUser = new Artist($con, $userArtist);
    $artistName = $artistUser->getArtistName();
    
    if (($_FILES['artwork']['name']!="")){
    // Where the file is going to be stored
        
        $prefixFolderArt = "../../";
        $target_dir_art = "assets/images/artwork/" . $artistName . "/";
        $file_art = $_FILES['artwork']['name'];
        $path_art = pathinfo($file_art);
        $filename_art = $songTitle;
        $ext_art = $path_art['extension'];
        $temp_name_art = $_FILES['artwork']['tmp_name'];
        $path_filename_ext_art = $prefixFolderArt.$target_dir_art.$filename_art.".".$ext_art;
        $artworkFile_art = $target_dir_art.$filename_art.".".$ext_art;
    }
    
    echo json_encode($artworkFile_art);
    
    if(file_exists($path_filename_ext_art)){
        echo "art already exists";
    } else {
        move_uploaded_file($temp_name_art,$path_filename_ext_art);
    }
    
    if (($_FILES['music']['name']!="")){
    // Where the file is going to be stored
        $prefixFolder = "../../";
        $target_dir = "assets/music/" . $artistName . "/singles/";
        $file = $_FILES['music']['name'];
        $path = pathinfo($file);
        $filename = $songTitle;
        $ext = $path['extension'];
        $temp_name = $_FILES['music']['tmp_name'];
        $path_filename_ext = $prefixFolder.$target_dir.$filename.".".$ext;
        $musicFile = $target_dir.$filename.".".$ext;

    // Check if file already exists
    if (file_exists($path_filename_ext)) {
        echo "Sorry, file already exists.";
     }else{
        move_uploaded_file($temp_name,$path_filename_ext);
        $dateCreated = date('Y-m-d H:i:s');
        $query = mysqli_query($con,"INSERT INTO SONG (title, duration, mp3File, releaseSong, totalListens, totalRating) VALUES ('$songTitle', '3:02', '$musicFile','$dateCreated',0,0)");
        $query = mysqli_query($con,"SELECT songID FROM SONG WHERE title='$songTitle' AND mp3File='$musicFile'");
        $songID = mysqli_fetch_array($query);
        $songID = $songID["songID"];
        $artistId = $artistUser->getArtistId();
        $query = mysqli_query($con,"INSERT INTO CREDIT VALUES ('main', $songID, $artistId)");
        $albTitle = "SINGLE - " . $songTitle; 
        $query = mysqli_query($con,"INSERT INTO ALBUM (title, artwork, releaseAlb) VALUES ('$albTitle','$artworkFile_art','$dateCreated')");
        $query = mysqli_query($con,"SELECT albumID FROM ALBUM WHERE title='$albTitle' ORDER BY releaseAlb DESC LIMIT 1");
        $albumID= mysqli_fetch_array($query);
        $albumID = $albumID["albumID"];
        $query = mysqli_query($con,"INSERT INTO ALBUM_INCLUSION VALUES (1,$albumID,$songID)");
        $query = mysqli_query($con,"INSERT INTO TAG_POSSESSION VALUES (4,$songID)");
        echo json_encode($query);
     }
    }
}


?>