<?php 
include("includes/includedFiles.php");
?>
<h1 class="pageHeadingBig">
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
        height: calc(100% - 90px);
        overflow: visible;
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, #1a1a1a, #1a1a1a);
    }
    
    .gridViewContainer {
        padding-bottom: 100px;
    }
     
</style>

<div class="gridViewContainer">
    <div class='viewQueueOnair'>
        <div class='viewQueue'>
            Recently Requested
            <hr>
            <?php 
            
            echo "<script src='assets/js/song-request.js'></script>";
            
            $query = mysqli_query($con, "SELECT * FROM SONG LIMIT 5");
            
            while($row = mysqli_fetch_array($query)){
                echo "<span  role='link' tabindex='0' ><div class='queueItem'><div class='queueItemInfo'><span class='artistInfo'>" . $row['title'] . "</span></div></div></span>";
            }
            
            ?>
        </div>


        <script>
            $(document).ready(function(){
                
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
                    let newSearchBlock = $("<div class='viewQueue'></div>");
                    for(let x of searchResult){
                        newSearchBlock.append("<span  role='link' tabindex='0' ><div class='queueItem'><div class='queueItemInfo'><span class='artistInfo' >" + x['title'] + "|<span class='song-title'>" + x['stageName'] + "</span></span><button onclick='sendReqApproval(this)'>REQUEST</button></div></div></span>");
                    }
                    $(".viewQueue").replaceWith(newSearchBlock);

                });

                event.preventDefault();
                    
              });
    

            });
            </script>
    </div>
</div>

