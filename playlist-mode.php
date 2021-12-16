<?php 
include("includes/includedFiles.php");
echo "<script src='assets/js/create-playlist.js'></script>"
?>
<h1 class="pageHeadingBig">Your Playlists</h1>

<style rel="stylesheet">  
    #mainViewContent {
        height:100%;
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    #newPlaylist:hover {
        cursor: pointer;
    }
    #songSelect {
        height: calc(100% - 90px);
        overflow: hidden;
    }
    #add-edit {
        top: 10%;
    }
    .container {
        font-size: 15px;
        display:inline-block;
    }
</style>
<div id="songSelect" class="overlay">

  <!-- Button to close the overlay navigation -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeSearch()">&times;</a>

  <!-- Overlay content -->
  <div id='add-edit' class="overlay-content">
      <div class="gridViewContainer">
          
          <div class='viewQueueOnair'>
              <div class='viewQueue'>
                  
              </div>

              <div class='viewOnair'>
                  
                  
              </div>
          </div>
          <div class="playlist-search-results search-results">
              
              <form id="searchForm">
                <p> 
                <input type="text" name="playlistName" id="plname" placeholder="Playlist name.." required>                    
                </p>
                  
                  <label class="container">Public
                      <input type="checkbox" name="public" id="public" placeholder="Public">
                      <span class="checkmark"></span>
                    </label>

                <button id="searchButton">search</button>
                  
                  <button type="submit" class="pausePlayBrowseSong">CREATE</button>

              </form>
          
          </div>
    </div>
  </div>

</div>



<div class="gridViewContainer">
    <div class='full-view-container'>
        <div class='full-view-item'>
        <?php 
            $userLoggedIn = $_GET["userLoggedIn"];
            $user = new User($con, $userLoggedIn);
            $userPlaylistIds = $user->getPlaylistIds();
            
            echo "
              <span onclick='setEditMode()' id='newPlaylist' role='link' tabindex='0' >
                  
                  <div class='queueItem'>
                  <div class='queueItemInfo'>
                  <img src='assets/images/icons/add-new.png'>
                  <span class='artistInfo margin-spacing'>" . "Create New Playlist" . " ";
                  
                  
                  echo "
                  </span>
                  </div>
                  </div>
              </span>
   
            ";
            
        $i = 1;
        foreach($userPlaylistIds as $row) {
              
              echo "
              <span  role='link' tabindex='0'>
                  
                  <div class='queueItem'>
                  <div class='queueItemInfo'>
                  <span class='artistInfo'><span class='trackNumber'>" . $i . "</span> " . $row["name"] . " ";
                  
                  
                  echo "
                  </span>
                  <button class=\"pausePlayAlbumSong margin-spacing\" onclick='openPage(\"playlist.php?id=" . $row["playlistID"] .  "&userId=" . $user->getUserId() . "&mode=" . "listen" . "\")'>LISTEN</button>
                  <button class=\"pausePlayAlbumSong\" onclick='openPage(\"playlist.php?id=" . $row["playlistID"] .  "&userId=" . $user->getUserId() . "&mode=" . "edit" . "\")'>EDIT</button>
                  </div>
                  </div>
              </span>
   
            ";
            $i++;
        };
            
            $playlistIdsArray = json_encode($userPlaylistIds);
        ?>
        </div>
        
        <div class='viewOnair'>
        
        <script>
            $(document).ready(function(){
                playlistIds = <?php echo $playlistIdsArray?>; 
 
            });
            </script>
        </div>
    </div>
</div>

