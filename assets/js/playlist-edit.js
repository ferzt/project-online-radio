function closeSearchEdit() {
    $("#songSelect").css("width","0");
    
    let newPlaylistSize = tempPlaylist.length;
    let numAddSongs = newPlaylistSize - numSongs;
    
    for(let i = (addedSongs.length - numAddSongs); i < addedSongs.length; i++) {
        
        let newElem = rowForm.clone();
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


function closeSearchNoChange() {
    $("#songSelect").css("width","0"); 
}
