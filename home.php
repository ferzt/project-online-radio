<?php 

include("includes/includedFiles.php");
?>
<h1 class="pageHeadingBig">
<!--
    Your Favorite Streams
    <div class="registerUser"><button class="pausePlayAlbumSong" onclick="setTrack(tempPlaylist[0],tempPlaylist,true)">START LISTENING</button></div>
-->
    <div class="topNav">
        <div class="search-container">
            <form>
                <button type="submit"><i class="fa fa-search"></i></button>
                <input type="hidden" value="song" id="search-scope" name="searchScope">
              <input type="text" name="songSearched" id="searchText" placeholder="Search.." name="search">
              
            </form>
          </div>
    </div>
</h1>


<style rel="stylesheet">  
    #mainViewContent {
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, #1a1a1a, #1a1a1a);
    }
    
    .gridViewContainer {
        padding-bottom: 100px;
    }

</style>

<div class="gridViewContainer">
    <div>
        <h2>Recent Releases</h2>
        <?php 
        $user = new User($con,$_GET["userLoggedIn"]);
        $userHearingInfo = $user->advertiseRecentReleases();
        $homePageSongIds = array();
              foreach($userHearingInfo as $row) {
                  array_push($homePageSongIds, $row["songID"]);
                  echo "<div class='gridViewItem' onclick='passTrackIndex(event);'>
                          <span  role='link' tabindex='0'>
                              <img onclick='openPage(\"track.php?&userLoggedIn=" . $_GET["userLoggedIn"] . "&id=" . $row["songID"]  . "\")' src='" . $row["album_art"] . "'><div class='play-on-demand'><button onclick='setTrack(". $row["songID"] . ", [" . $row["songID"] .  "]" . ",true)'><img src='assets/images/icons/play.png'></button></div>
                              <div class='gridViewInfo'>" . $row["song_title"] . "
                              </div>
                          </span>
                        </div>";
                }
        ?>
    
    </div>
    <div>
        <h2>Your favorite streams</h2>
        <?php 
        $userHearingInfo = $user->getFavoriteSongs();
              foreach($userHearingInfo as $row) {
                  array_push($homePageSongIds, $row["songID"]);
                  echo "<div class='gridViewItem' onclick='passTrackIndex(event);'>
                          <span  role='link' tabindex='0'>
                              <img onclick='openPage(\"track.php?&userLoggedIn=" . $_GET["userLoggedIn"] . "&id=" . $row["songID"]  . "\")' src='" . $row["album_art"] . "'><div class='play-on-demand'><button onclick='setTrack(". $row["songID"] . ", [" . $row["songID"] .  "]" . ",true)'><img src='assets/images/icons/play.png'></button></div>
                              <div class='gridViewInfo'>" . $row["song_title"] . "
                              </div>
                          </span>
                        </div>";
                }
        ?>
    
    </div>
    
</div>

<script>
        tempPlaylist = <?php echo json_encode($homePageSongIds); ?>;
        favorites = tempPlaylist.map(id => false);
        var play = false, pause = false;
        $(document).ready(function(){
            
            
            $(document).on("click", ".play-on-demand button", function(){
               let loc = $(this).parent().parent().parent().index(); 
                $(".gridViewItem button img").not(this).attr("src","assets/images/icons/play.png");
                $(this).children().eq(0).attr("src","assets/images/icons/pause.png");
                for(let target = 0; target < favorites.length; target++) {
                    favorites[target] = false;
                }
                favorites[loc] = !favorites[loc];
            })
            
            $(document).on("mouseover", ".gridViewItem", function(){
               let loc = $(this).index();
              
                if(favorites[loc]) {
                    $(this).children().children().eq(1).children().children().eq(0).attr("src","assets/images/icons/pause-on-demand.png");
                } else {
                    $(this).children().children().eq(1).children().children().eq(0).attr("src","assets/images/icons/play-on-demand.png");
                    
                }
            })
            
            $(document).on("mouseout", ".gridViewItem", function(){
                let loc = $(this).index(); 
                if(favorites[loc]) {
                    $(this).children().children().eq(1).children().children().eq(0).attr("src","assets/images/icons/pause.png");
                } else {
                    $(this).children().children().eq(1).children().children().eq(0).attr("src","assets/images/icons/play.png");
                    
                }
            })

            searchResult=[];

            $("form").submit(function (event) {

            var formData = {
              songSearched: $("#searchText").val(),
                searchScope: $("#search-scope").val(),
            };
                
            $.ajax({
              type: "POST",
              url: "includes/handlers/songsearch-handler.php",
              data: formData,
              dataType: "json",
              encode: true,
            }).done(function (data) {
               
                searchResult=data;
                let arrayOfSearch = [];
                let newSearchBlock = $("<div class='gridViewContainer'></div>");
                for(let x of searchResult){
                    let temp = [];
                    temp.push(x["songID"]);
                    newSearchBlock.append("<div class='gridViewItem' onclick='passTrackIndex(event);'><span  role='link' tabindex='0'><img onclick='openPage(\"track.php?&userLoggedIn=" + userLoggedIn + "&id=" + x["songID"]  + "\")' src='" + x["artwork"] + "'><div class='play-on-demand'><button onclick='setTrack(" + x["songID"] + ", [" + temp +  "] " + ",true)'><img src='assets/images/icons/play.png'></button></div><div class='gridViewInfo'>" + x["stageName"] + " <span class='song-title'>" + x["title"] + "</span></div></span></div>");
                }
                $(".gridViewContainer").replaceWith(newSearchBlock);
                favorites = searchResult.map(id => false);
            });

            event.preventDefault();

          });


        });
</script>