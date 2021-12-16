<?php include("includes/includedFiles.php"); 
    if(isset($_GET['id'])) {
        $collectionId = $_GET['id'];
        $songUserId = $_GET['songUserId'];//song id to get artist or user id to get user
        $type = $_GET["type"];
    } 
    else {
        header("Location: index.php");
    }

$collection = new Collection($con,$collectionId, $songUserId, $type);
?>

<style rel="stylesheet">  
    #mainViewContent {
        height:calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
</style>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $collection->getArtworkPath();?>" width="220">
    </div>
    
    <div class="rightSection">
        <h2><?php echo $collection->getTitle();?></h2>
        <p>By <?php echo $collection->getArtist(); ?></p>
        <p><?php echo $collection->getNumberOfSongs(); ?> songs</p>
        <button class="pausePlayAlbumSong">PAUSE</button>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">
            
            
            <?php
            $songIdArray = $collection->getSongIds();
            $i=1;
            
            foreach($songIdArray as $songId){
                $collectionSong = new Song($con, $songId);   
                $collectionArtists = $collectionSong->getArtist();
                $collectionMain = array_shift($collectionArtists);
                
                echo "<li class='trackListRow' onmouseover='setMouseOverStateForAlbumSongs(this)' onmouseout='setMouseOutStateForAlbumSongs(this)'>
                <div class='trackCount'>
                    <img alt='play' class='playIconOnHover' src='assets/images/icons/playwhite.png' onclick='setTrack(\"".$songId ."\",tempPlaylist,true);manageStyleOnPlay(this)'>
                    <span class='trackNumber'>$i</span>
                </div>
                
                <div class='trackInfo'>
                    <span class='trackName'>" . $collectionSong->getTitle() . "</span>
                    <span class='artistName'>" . $collectionMain;
                
                foreach($collectionArtists as $songFeature){
                    if(empty($songFeature)){
                        echo "";
                    } else {
                        echo ", " . $songFeature;
                    }
                    
                }
                
                 echo " </span>
                    
                </div>
                
                <div class='trackOptions'>
                    <img class='optionsButton' src='assets/images/icons/ellipsis.png'>
                </div>
                
                <div class='trackDuration'>
                    <span class='duration'>" . $collectionSong->getDuration(). "</span>
                
                </div>
                
                </li>";
                $i++;
            }
            
            
            ?>
        
        <script>
            var tempSongIds = <?php echo json_encode($songIdArray); ?>;
            tempPlaylist = tempSongIds;
        </script>
    
    
    </ul>

</div>

