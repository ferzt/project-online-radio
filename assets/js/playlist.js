function setEditMode() {
    $("#songSelect").css("width", "calc(100% - 220px)");
}

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
        let arrayOfSearch = [];
        searchResult=data;
        
        let newSearchBlock = $("<div class='playlist-search-results search-results'></div>");
        let i = 1;
        for(let x of searchResult){
            newSearchBlock.append("<span  role='link' tabindex='0' ><div class='queueItem'><div class='queueItemInfo'><span class='artistInfo'>" + x['title'] + "|<span class='song-title'>" + x['stageName'] + "</span></span><button onclick='addToPlaylist(this,searchResult)'><img src='assets/images/icons/add-playlist.png'></button></div></div></span>");
            i++;
        }
        $(".playlist-search-results").replaceWith(newSearchBlock);

    });

    event.preventDefault();
});

function addToPlaylist(elem) {
    let locInParent = $(elem).parent().parent().parent().index();
    $(elem).children().attr("src","assets/images/icons/confirm-playlist.png");
    tempPlaylist.push(searchResult[locInParent]["songID"]);
    addedSongs.push(searchResult[locInParent]);
}

function closeSearch() {
    $("#songSelect").css("width","0");
    
    let newPlaylistSize = tempPlaylist.length;
    let numAddSongs = newPlaylistSize - numSongs;
    
    for(let i = (addedSongs.length - numAddSongs); i < addedSongs.length; i++) {
        
        let newElem = $(".trackList").children().eq(0).clone();
        newElem.children().eq(0).children().eq(0).text(i+1+numSongs);
        newElem.children().eq(1).children().eq(0).text(addedSongs[i]["title"]);
        newElem.children().eq(1).children().eq(1).text(addedSongs[i]["stageName"]);
        
        for(let j = 0; j < addedSongs[i]["features"].length; j++) {
            newElem.children().eq(1).children().eq(1).append(", " + addedSongs[i]["features"][j]);            
        }
        
        newElem.children().eq(3).children().eq(0).text(addedSongs[i]["duration"]);
    
        newElem.appendTo(".trackList");  
        
    }
    
    
    numSongs = tempPlaylist.length;   
}

function sortUp(elem) {
    let currIndex = $(elem).parent().parent().index();
    let prevIndex = $(elem).parent().parent().index()-1;

    if(prevIndex >= 0 && currIndex) {
        let trackRow = $(elem).parent().parent().parent().children().eq(currIndex);
        let swapRow = $(elem).parent().parent().parent().children().eq(prevIndex);

        swapRow.before(trackRow);

        let temp = tempPlaylist[currIndex];
        tempPlaylist[currIndex]= tempPlaylist[prevIndex];
        tempPlaylist[prevIndex] = temp;
    }
    
}

function sortDown(elem) {
    let currIndex = $(elem).parent().parent().index();
    let nextIndex = $(elem).parent().parent().index()+1;

    if(nextIndex < tempPlaylist.length) {
        let trackRow = $(elem).parent().parent().parent().children().eq(currIndex);
        let swapRow = $(elem).parent().parent().parent().children().eq(nextIndex);

        trackRow.before(swapRow);

        let temp = tempPlaylist[currIndex];
        tempPlaylist[currIndex]= tempPlaylist[nextIndex];
        tempPlaylist[nextIndex] = temp;
    }
    
}

function updatePlaylistTracks () {
    let playlistOrder = tempPlaylist;
    $.post("includes/handlers/ajax/updatePlaylistTracksJson.php",{playlistOrder:playlistOrder, playlistID:playlistId}, 
           function(data){   
    });
}
