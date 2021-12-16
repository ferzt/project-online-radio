<?php include("includes/includedFiles.php"); 
    if(isset($_GET['id'])) {
        $playlistId = $_GET['id'];
        $userId = $_GET['userId'];//song id to get artist or user id to get user
        $playlistMode = $_GET["mode"];
        
        $buttonText;
        if($playlistMode == "edit"){
            $buttonText = "ADD SONGS";
        } else {
            $buttonText = "PLAY";
        }
    } 
    else {
        header("Location: index.php");
    }

$playlist = new Playlist($con,$playlistId,$playlistMode);

echo "<script src='assets/js/playlist.js'></script>";
echo "<script src='assets/js/playlist-edit.js'></script>"

?>
<div id="songSelect" class="overlay">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeSearchNoChange()">&times;</a>

  <!-- Overlay content -->
  <div id='add-edit' class="overlay-content">
      <div class="gridViewContainer">
          
          <div class='viewQueueOnair'>
              <div class='viewQueue'>
                  <button onclick="closeSearchEdit()" class="pausePlayBrowseSong">SAVE</button>
              </div>

              <div class='viewOnair'>
                  <form id="searchForm">
                    <p> 
                    <input type="text" name="songSearched" id="searchText" placeholder="Enter a Song Search.." required>
                        <input type="hidden" value="song" id="search-scope" name="searchScope">
                    </p>

                    <button id="searchButton" type="submit">search</button>
                      

                  </form>
                  
              </div>
          </div>
          <div class="playlist-search-results search-results"></div>
    </div>
  </div>

</div>

<style rel="stylesheet">  
    #mainViewContent {
        height:100%;
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    #songSelect {
        height: calc(100% - 90px);
        overflow: hidden;
    }
    #add-edit {
        top: 10%;
    }
    .queueItemInfo button {
        background-color: #FFF;
        border-radius:50%;
        border: none;
        padding:0px;
    }
    .queueItemInfo img {
        width: 30px;
    }
    .queueItemInfo {
        padding: 5px;
        box-sizing: border-box;
    }
    .trackOptions button {
        background-color: transparent;
        border:none;
        width:100%;
    }
</style>

<div class="entityInfo">
    <div class="leftSection">
    </div>
    
    <div class="rightSection">
        <h2><?php echo $playlist->getName();?></h2>
        <p>By <?php echo $playlist->getUser(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button onclick='<?php if($playlistMode=="edit") {echo 'setEditMode()';} else {echo 'setTrack(tempPlaylist[0],tempPlaylist, true)';} ?>' class="pausePlayAlbumSong"><?php echo $buttonText;?></button>
        <?php if($playlistMode=="edit") {echo "<button onclick='updatePlaylistTracks()' class='pausePlayAlbumSong'>UPDATE</button>";} ?>
    </div>
</div>

<div class="trackListContainer">
    <ul class="trackList">
    
    
    </ul>
    <script>
        let rowForm = $("<li class='trackListRow' onmouseover='setMouseOverStateForAlbumSongs(this)' onmouseout='setMouseOutStateForAlbumSongs(this)'><div class='trackCount'><span class='trackNumber'></span></div><div class='trackInfo'><span class='trackName'></span><span class='artistName'></span></div><div class='trackOptions'><button onclick='sortUp(this)'><img class='optionsButton' src='assets/images/icons/sort-up.png'></button><button onclick='sortDown(this)'><img class='optionsButton' src='assets/images/icons/sort-down.png'></button></div><div class='trackDuration'><span class='duration'>duration</span></div></li>");
        

        var searchResult = [], addedSongs = [];
        var numSongs = 0;
        var playlistId = <?php echo json_encode($playlistId); ?>;


    </script>

</div>

