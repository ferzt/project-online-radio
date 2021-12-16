/** Queue.js to perform ajax calls to server to update song on air and to approve songs from queue to go on air.

**/

var songsOnQueue, songOnAir;

function approveSong(songId){
    let currTime = new Date();
    let adminId = 25;
   $.post("includes/handlers/ajax/approveSongOnAirJson.php",{songId:songId, currentTime: currTime.toJSON(), approvedBy:adminId}, function(data){
    });
}

function updateOnAirSeq(index){
    let currTime = new Date();
    $.post("includes/handlers/ajax/updateOnAirSeq.php",{currentTime: currTime.toJSON()});
    refreshPage();       
}

function setSongAsOnAir(songId) {
    let currTime = new Date();
    $.post("includes/handlers/ajax/setSongAsOnAirJson.php",{currentTime: currTime.toJSON(), songId:songId});
}




