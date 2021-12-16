<?php 
include("includes/includedFiles.php");
?>
<h1 class="pageHeadingBig">Approve Songs On Queue</h1>

<style rel="stylesheet">  
    #mainViewContent {
        height:calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
</style>

<div class="gridViewContainer">
    <div class='viewQueueOnair'>
        
        <div class='viewQueue'>
            <h3>QUEUE</h3>
        <?php 
            echo "<script src='assets/js/queue.js'></script>";

            $approvedSongsArray = array();

        $queueQuery = mysqli_query($con, "SELECT * FROM ON_AIR WHERE priority = 10 ORDER BY timer") ;
        $songOnQueueQuery; 
        $artistOnQueueQuery; 
        $creditOnQueueQuery; $corrArray = 0;
        $songOnQueue = array(); $arrayItem = array();
        while($row = mysqli_fetch_array($queueQuery)) {
            $songID = $row["songRef"]; //songID
            //Get title, duration, mp3File, releaseSong
            $songOnQueueQuery = mysqli_query($con, "SELECT * FROM SONG WHERE songID = '$songID'") ;
            $songRow = mysqli_fetch_array($songOnQueueQuery);
            array_push($songOnQueue, $songRow); //only one item
            //Get Artists on song
            $creditOnQueueQuery = mysqli_query($con, "SELECT * FROM CREDIT WHERE songCredit = '$songID' ") ;
            $artistOnQueue = array();
            //Get stage names of artists
            while($col = mysqli_fetch_array($creditOnQueueQuery)) {
                $artistID = $col["artistCredit"];
                $artistOnQueueQuery = mysqli_query($con, "SELECT stageName FROM ARTIST WHERE artistID = '$artistID'") ;
                while($artRow = mysqli_fetch_array($artistOnQueueQuery)){
                    array_push($artistOnQueue, $artRow["stageName"]);
                }
                
            }
            $albOnQueueQuery = mysqli_query($con, "SELECT * FROM ALBUM_INCLUSION WHERE songAlbum = '$songID' ") ;
            $albOnQueue = mysqli_fetch_array($albOnQueueQuery);
            $albumID = $albOnQueue["album"];
            $albArtOnQueueQuery = mysqli_query($con, "SELECT * FROM ALBUM WHERE albumID = '$albumID' ") ;
            $albArtOnQueue = mysqli_fetch_array($albArtOnQueueQuery);
            $songOnQueue[$corrArray]["stageName"] = $artistOnQueue;
            $songOnQueue[$corrArray]["albumArt"] = $albArtOnQueue["artwork"];
            $corrArray++;
        }
        foreach($songOnQueue as $row) {
              
              echo "
              <span  role='link' tabindex='0' onclick='openPage(\"#\")'>
                  
                  <div class='queueItem'>
                  <div class='queueItemInfo'>
                  <img src='" . $row["albumArt"] . "'>
                  <div class='stack-item'><span class='artistInfo'>" . $row["stageName"][0] . " ";
                  
                  for($count = 1; $count <= count($row["stageName"])-1; $count++){
                    echo " ft. " . $row['stageName'][$count];
                  }
            
                    echo "</span><span class='item-bottom'>" . $row["title"];
                  
                  echo "
                  </span>
                  </div>
                  <button class='pausePlayBrowseSong' onclick='approveSong(" . $row["songID"] . ")'>APPROVE</button>
                  </div>
                  </div>
              </span>
   
            ";
        };
            
            $songsOnQueue = json_encode($songOnQueue);
        ?>
        </div>
        
        <div class='viewOnair'>
            <h3>ON-AIR</h3>
        <?php
        $onairQuery = mysqli_query($con, "SELECT * FROM ON_AIR WHERE priority = 0 OR priority = 1 ORDER BY priority, timer") ;
        $songOnAirQuery; 
        $artistOnAirQuery; 
        $creditOnAirQuery; $corrArray = 0;
        $songOnAir = array(); $arrayItem = array();
        while($row = mysqli_fetch_array($onairQuery)) {
            array_push($approvedSongsArray, $row["songRef"]);
            $songID = $row["songRef"]; //songID
            //Get title, duration, mp3File, releaseSong
            $songOnAirQuery = mysqli_query($con, "SELECT * FROM SONG WHERE songID = '$songID'") ;
            $songRow = mysqli_fetch_array($songOnAirQuery);
            array_push($songOnAir, $songRow); //only one item
            //Get Artists on song
            $creditOnAirQuery = mysqli_query($con, "SELECT * FROM CREDIT WHERE songCredit = '$songID' ") ;
            $artistOnAir = array();
            //Get stage names of artists
            while($col = mysqli_fetch_array($creditOnAirQuery)) {
                $artistID = $col["artistCredit"];
                $artistOnAirQuery = mysqli_query($con, "SELECT stageName FROM ARTIST WHERE artistID = '$artistID'") ;
                while($artRow = mysqli_fetch_array($artistOnAirQuery)){
                    array_push($artistOnAir, $artRow["stageName"]);
                }
                
            }    
            $albOnAirQuery = mysqli_query($con, "SELECT * FROM ALBUM_INCLUSION WHERE songAlbum = '$songID' ") ;
            $albOnAir = mysqli_fetch_array($albOnAirQuery);
            $albumID = $albOnAir["album"];
            $albArtOnAirQuery = mysqli_query($con, "SELECT * FROM ALBUM WHERE albumID = '$albumID' ") ;
            $albArtOnAir = mysqli_fetch_array($albArtOnAirQuery);
            $songOnAir[$corrArray]["stageName"] = $artistOnAir;
            $songOnAir[$corrArray]["albumArt"] = $albArtOnAir["artwork"];
            $corrArray++;
        }
        $marker = 0;
            $buttonText;
            $nowPlayingSong;
        foreach($songOnAir as $row) {
                if($marker == 0){
                     $buttonText = "PLAYING"; 
                    $nowPlayingSong = "now-playing-song-air";
                  } else {
                      $buttonText = "UP&nbsp;NEXT";
                    $nowPlayingSong = "";
                  }
              
              echo "
              <span  role='link' tabindex='0' onclick='openPage(\"#\")'>
                  
                  <div class='queueItem'>
                  <div class='queueItemInfo'>
                  <img src='" . $row["albumArt"] . "'>
                  <div class='stack-item'><span class='artistInfo'>" . $row["stageName"][0] . " ";
                  
                  for($count = 1; $count <= count($row["stageName"])-1; $count++){
                    echo "ft. " . $row['stageName'][$count];
                  }
                  
                  echo "</span><span class='item-bottom'>" . $row["title"] . 
                  "</span>
                  </div>
                  <button class='" . $nowPlayingSong . " pausePlayBrowseSong'onclick='setTrack(\"".$row["songID"] ."\",tempPlaylist,true);setSongAsOnAir(" . $row["songID"] . ")'>" . $buttonText . "</button>
                  </div>
                  </div>
              </span>";
            $marker++;
        };
            $songOnAirNow = json_encode($songOnAir);
        ?>
        <script>
            $(document).ready(function(){
                songsOnQueue = <?php echo $songsOnQueue ?>; 
                songOnAir = <?php echo $songOnAirNow ?>; 
                tempPlaylist = <?php echo json_encode($approvedSongsArray); ?>; 
            });
            </script>
        </div>
    </div>
</div>

