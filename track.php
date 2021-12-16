<?php 
include("includes/includedFiles.php");

    $userId = $_GET["userLoggedIn"];
    $songId = $_GET["id"];
    $song = new Song($con, $songId);
    $artists = $song->getArtist();
    $tag = $song->getTag();

?>
<h1 class="pageHeadingBig"><?php echo $song->getTitle()?></h1>

<style rel="stylesheet">  
    #mainViewContent {
        height:100%;
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
</style>

<div class="gridViewContainer">
    <div class='viewQueueOnair'>
        <div class='viewQueue trackPage'>
            <div class="entityInfo">
                <div class="topSection">
                </div>
                <div class="leftSection">
                    <img src="<?php echo $song->getArtworkPath();?>" width="75%">
                </div>

                <div class="rightSection">

                </div>
                
            </div>
           
        </div>
        
        <div class='viewOnair'>
            <div class="bottomSection track-page-right">
                <h2><?php 
                    $i = 0;
                    foreach($artists as $ind) {
                        if($i > 0){
                            echo "ft " . $ind . " ";
                        } else {
                            echo $ind . " ";
                        }
                        $i++;
                    }
                    
                    ?>
                </h2>
                <p class="tag">Tag: <?php echo $tag["tagName"] . " " . $tag["tagDescribe"] ?></p>
                <p class="albumTitle">Album : <?php echo $song->getAlbumTitle()?></p>
                <p class="listenOn"><?php echo "<p class='listenOn'><button class='pausePlayBrowseSong' onclick='openPage(\"collection.php?&songUserId=" . $songId . "&type=" . "album" . "&id=" . $song->getAlbum() . "\")'>LISTEN TO ALBUM</button></p>"; ?> </p>
                <p class="last-listened">Last Listen Date</p>
                <p class="rating-stars">Rating</p>
                
            </div>

        </div>
    </div>
</div>

