/** The openPage and includedFiiles.php work together. Loading content into the mainViewContent div only requires that the index.php only has the gridViewContainer ; no header or footer as they contain the navbar and nowplaying bar. so we get rid of the header and footer in index.php, and put it in included files. 

If the user loads index.php dynamically, using the openPage function below, the navBar and Playing bar are kept from the current album page but content is only loaded ito mainViewContent. NOW THE TRICKY PART - THIS IS MY UNDERSTANDING - php code is usually executed first before html,css & javascript. 

In that sense, the header and footer files write all the html and javascript they have onto the page. So linked stylesheets, the jquery file and so on are written to the page before the rest of the html and javascript. However, when reloading mainViewContent, we are essentially using ajax, so we must include a;; php files needed to reexecute the 10 random albums on the home page. 

That's why you do not need to reload the whole header and footer files, just include the artist.php, config.php etc. However if you just put the index.php in the url bar, you'll need to reconstruct the whole page with the header and footer files. And since the index.php does not have anything beside the gridViewContainer stuff, it gets buried when you load the header and footer untop of it. So you'll need to use ajax again to reload mainViewContent 

**/

var audioElement, mouseDownPlay = false, mouseUpPlay = false, mouseUpOverPlayBar = false, mouseDownVolume =  false;
var currentPlaylist = [], shufflePlaylist=[],tempPlaylist=[];
var currentIndex=0;
var shuffle = false, repeat = false;
var anyElem;

function openPage(url){
    
    let userDef = true;
    try {
        userLoggedIn=userLoggedIn
    } catch(err){
        userDef= false;
    }
    
    if(url.indexOf('?')==-1 && userDef){
        url=url+"?";
        url = encodeURI(url+"&userLoggedIn="+userLoggedIn);   
    }
    
    if(userDef) {
        $("#mainViewContent").load(url);
        $("body").scrollTop(0);
        history.pushState(null,null,url);
    } else {
        $("body").load(url);
        history.pushState(null,null,url);
    }
    
}

function refreshPage(){
    let url = window.location.href;
    $("#mainViewContent").load(url);
    $("body").scrollTop(0);
    history.pushState(null,null,url);
}

function passTrackIndex(elem){
    let parentEl = $(elem.target).parent().parent().parent();
    let targetEl = $(elem.target).parent().parent();
    anyElem = parentEl.children().index(targetEl);
}


function manageStyleOnPlay(item){
    var otherSongs = $(item).parent().parent().siblings("li"), eachSongRow;
 
    
    
    
    /**
    When a jquery Object is retuned such as otherSongs and playingVolume, there are a couple of ways to handle them. 1 - Either use the fields in the object, as outline by the console to set attributes. Not everything can be set in this manner though. Here just use the Object[number] to reference which object/attr you want to access in the list, and dots for chaining.
    2- use .eq(number) to select the jquery object you want in the list. Doing this keeps it as a jquery object and you can perform any jquery actions on it without using the [number]. Actions such as append, prepend etc can be used with this method
    - object[number] -  returns a javascript object so you have to use javascript methods
    - object.eq(number) -  returns a jquery object so you have to use jquery methods -  can also possibly use Array.slice() since it is an array of jquery objects
    **/
    
    //Reset the text color of the other tracks on page/playlist
    for(var k=0; k < otherSongs.length; k++){
        otherSongs[k].children[1].children[0].style.color="#fff";
        otherSongs[k].children[3].children[0].style.color="#fff";
        var nonPlayingListItem = otherSongs[k].firstElementChild;
        if(nonPlayingListItem.childElementCount > 2){
            var reference = nonPlayingListItem.querySelector(".playIconOnPlay");
            reference.parentNode.removeChild(reference);
            otherSongs.slice(k,k+1).children().eq(0).find("span.trackNumber").show();
        }
    }
    var playingVolume = $(item).next();
    
    
    //Place Image Icon infront of track Number
    $('<img class="playIconOnPlay" src="assets/images/icons/playing.png">').insertBefore(playingVolume);
    
    //hide track Number
    playingVolume.hide();
    
    //set the track name and duration to theme color
    $(item).parent().next().find("span.trackName").css("color","#c69c6d");
    $(item).parent().parent().find("div.trackDuration").find("span.duration").css("color","#c69c6d");
    

}

function formatTime(seconds){
    var timeInSec = Math.round(seconds);
    var minutes = Math.floor(timeInSec/60);
    var seconds = timeInSec - (minutes*60);
    
    if(seconds<10){
        var extraZero = 0;
    } else {
        var extraZero = "";
    }
    
    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio, newCurrentTime) {
    $(".progressTime.current").text(formatTime(newCurrentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - newCurrentTime));
    
    var progress = newCurrentTime/audio.duration * 100;
    var progressCircleWidth = $(".playbackBar .progressBar").width()-10;

    var progressCircle = progress/100*progressCircleWidth;

    $(".playbackBar .progress").css("width", progress + "%");
    $(".playbackBar .progressCircle").css("left", progressCircle);
}

function updateVolumeProgressBar(audio) {
    var progress = audio.volume * 100;
    $(".volumeBar .progress").css("width", progress + "%");
}

function Audio() {
    this.currentlyPlayingSong;
    this.scenario;
    this.audio = document.createElement("audio");
    
    //can play is used when a media (audio/video) has buffered enough to start playing
    this.audio.addEventListener("canplay", function(){
        $(".progressTime.remaining").text(formatTime(this.duration));
    });
    
    this.audio.addEventListener("timeupdate", function(){

        if(mouseDownPlay==false){
           updateTimeProgressBar(this, this.currentTime); 
        }
        
    });
    
    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });
    
    this.audio.addEventListener("ended", function(){
            nextSong();                     
    });
    
    this.setTrack = function(track){
        this.currentlyPlayingSong = track;
        
        this.audio.src=track.mp3File;
    }
    
    this.play = function() {
        this.audio.play();
    }
    
    this.pause = function() {
        this.audio.pause();
    }
    
    this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}
    
    this.setScenario = function(userType){
        this.scenario = userType;
    }
}