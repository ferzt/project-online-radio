<?php 
    include("includes/config.php");
    $songQuery = mysqli_query($con, "SELECT * FROM ON_AIR WHERE priority = 0");
    
    $resultArray = array();
    $syncTimerArray = "0";

    if($songQuery){
        while($row = mysqli_fetch_array($songQuery)){
            array_push($resultArray, $row['songRef']);
            $syncTimerArray = $row['timer'];
        }
        
    }
    
    $syncTimerArray = json_encode($syncTimerArray);
    $jsonArray = json_encode($resultArray);
?>

<script>    
    $(document).ready(function(){
        var progressBarSelector = $(".playbackBar .progressBar"), eventRecord;
        let syncTimer = <?php echo $syncTimerArray ?>;
        syncTimer = (Date.now() - Date.parse(syncTimer))/1000;
        newPlaylist = <?php echo $jsonArray ?>;
        audioElement = new Audio;
        if(newPlaylist.length != 0){
            setTrack(newPlaylist[0],newPlaylist,false, syncTimer);
        } else {
            $("#myNav").css("width","100%");
        }
        updateVolumeProgressBar(audioElement.audio);
        
        $(document).on("mousedown", "button.pausePlayAlbumSong, button.pausePlayBrowseSong", function(e) {
            $(this).css("background-color", "#c69c6d");
        });
        
        $(document).on("mouseup", "button.pausePlayAlbumSong, button.pausePlayBrowseSong", function(e) {
            $(this).css("background-color", "#2E3192");
        });
        
        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
           e.preventDefault();  // make sure () is after preventDefault. Removes highlighting of buttons
        });
        
        $(".playbackBar .progressBar").mouseover(function(){
            setHoverEffects("visible", "#2E3192");
        });
        
        $(".playbackBar .progressBar").mouseout(function(){
            if(mouseDownPlay){
                setHoverEffects("visible", "#2E3192");                
            } else {
                setHoverEffects("hidden", "#a0a0a0"); 
            }
            
        });
        
        $(".playbackBar .progressBar").mousedown(function(){
            mouseDownPlay = true;
        })
        
        $(".playbackBar .progressBar").mousemove(function(e){
            eventRecord = e;
            if (mouseDownPlay == true) {
                var mousePositionRel = e.offsetX;
                timeFromOffset(mousePositionRel, this);
            }
        });
        
        $(".playbackBar .progressBar").mouseup(function(e){
            mouseUpPlay = true;
            mouseDownPlay = false;
            var mousePositionRel = e.offsetX;
            timeFromOffset(mousePositionRel, this);
        });
        
        $("#mainContainer:not(.playbackBar)").mousemove(function(e){
            if(mouseDownPlay == true){
                
                if(e.pageX < ($(progressBarSelector).offset().left)){
                    
                    audioElement.setTime(0);
                } else {
                    if(e.pageX >= ($(progressBarSelector).offset().left) && e.pageX < ($(progressBarSelector).offset().left+$(progressBarSelector).width())){
                        
                        var mousePositionRel = e.pageX-$(progressBarSelector).offset().left;
                        mouseUpOverPlayBar = true;
                        timeFromOffset(mousePositionRel, progressBarSelector);
                    } else {
                        
                    }
                }
                
            }                                                                     
        });
        
        $("#mainContainer:not(.playbackBar)").mouseup(function(e){
            if(mouseUpOverPlayBar){
                mouseUpPlay = true;
                mouseDownPlay = false;
                mouseUpOverPlayBar = !mouseUpOverPlayBar;
                var mousePositionRel = e.pageX-$(progressBarSelector).offset().left;
                timeFromOffset(mousePositionRel, progressBarSelector);
            }
        });
        
        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        })
        
        $(".volumeBar .progressBar").mousemove(function(e){
            try {
            if (mouseDown == true) {
                mouseDown = false;
                var percentage = e.offsetX/$(this).width();
                if(percentage >= 0 && percentage <=1) { // if user pulls makes mouse move and pulls mouse pointer beyond volume area - volume becomes greater than one, an invalid value
                    audioElement.audio.volume = percentage;   
                }
            }
            } catch(err) {}
        })
        
        $(".volumeBar .progressBar").mouseup(function(e){
            var percentage = e.offsetX/$(this).width();
            if(percentage >= 0 && percentage <=1) { 
                audioElement.audio.volume = percentage;   
            }
        });
        
        
    });
    
    function timeFromOffset(mouse, progress){
        var percentage = mouse/$(progress).width();

        var time = percentage*audioElement.audio.duration;

        if(mouseUpPlay == true) {
            audioElement.audio.currentTime = time;
            mouseUpPlay = !mouseUpPlay;
        } else {
            updateTimeProgressBar(audioElement.audio, time);
        }
    }
    
    function prevSong() {
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
            audioElement.setTime(0);
        } else {
            currentIndex -= 1;
            var nextSongToHighlight = $("ul.trackList li:eq(" + currentIndex + ") div img.playIconOnHover");
            
            manageStyleOnPlay(nextSongToHighlight);
            setTrack(currentPlaylist[currentIndex],currentPlaylist,true);
        }
    }
    
    function nextSong(){

        $.post("includes/handlers/ajax/getNextSongOnAirJson.php", function(data){
                
                var nextSong = JSON.parse(data);
                var timer = (Date.now() - Date.parse(nextSong.timer))/1000
                setTrack(nextSong.songRef,currentPlaylist,true,timer );
            });
        
    }
    
    
    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var repeatImage = audioElement.audio.muted ? "assets/images/icons/mute.png" : "assets/images/icons/volume.png";
        $(".controlButton.volume img").attr("src",repeatImage);
    }
    
    function setHoverEffects(visibility, bgColor) {
        $(".playbackBar .progressCircle").css("visibility", visibility);
        $(".playbackBar .progress").css("backgroundColor", bgColor);
    }
    
    function setMouseOverStateForAlbumSongs(referenceLI) {
            if($(referenceLI).children().eq(0).find("span.trackNumber").css("display")=="none"){
            } else {
                $(referenceLI).children().eq(0).find("img.playIconOnHover").css("visibility","visible");
            }
    }
    
    function setMouseOutStateForAlbumSongs(referenceLI) {
            $(referenceLI).children().eq(0).find("img.playIconOnHover").css("visibility","hidden");
    }
    
    function setPageDesignsForBrowsePage(referenceElement) {

        
        $(referenceElement).parent().prev().css("paddingTop","8px");
        $(referenceElement).parent().prev().width("175px");
        var stretchParameter = ["+=10px","-=20px","+=25px","-=15px"], paddingAddition = "-=0.75px";
        for(var k=0;k<8;k++){
            $(referenceElement).parent().prev().animate({height:stretchParameter[k%4],width:stretchParameter[k%4],paddingTop:"8px"});
            
            
        }
        
        
    }
    
        /**
     * Randomize array element order in-place.
     * Using Durstenfeld shuffle algorithm.
     */
    function shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
    }
    
    function setTrack(trackId, newPlaylist, play, syncTimer){
        pauseSong();

        let songTimeSync = syncTimer;
        if(currentPlaylist != newPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }
        
        if(shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
            
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        
        $.post("includes/handlers/ajax/getSongJson.php",{songId: trackId}, function(data){
            var track = JSON.parse(data);
            
            $(".trackName span").text(track.title);
            $(".bottomSection h2").text(track.title);
            audioElement.setTrack(track);
            audioElement.setTime(songTimeSync);

            if(play){
                playSong();
            }

            
            $.post("includes/handlers/ajax/getSongArtistsJson.php",{artistId: track.songID}, function(data){
                
                var artists = JSON.parse(data);
                
                $(".artistName span").text(artists[0]);
                $(".bottomSection .artistName").text(artists[0]);
                if(artists.length > 1){
                    for(let i=1; i < artists.length; i++) {
                        $(".artistName span").append(", " + artists[i]);
                    }
                }
            });
            
            $.post("includes/handlers/ajax/getAlbumJson.php",{albumId: track.songID}, function(data){
                var album = JSON.parse(data);
                
                $(".albumLink img").attr("src",album.artwork);
                $(".leftSection img").attr("src",album.artwork);
                $(".bottomSection .albumTitle").text(album.title);
            });
            
        });
              
    }
    
        
    function playSong() {
        let playAnimOptions = ["assets/images/backgrounds/wave-animation.gif", "assets/images/backgrounds/wave-animation2.gif", "assets/images/backgrounds/wave-animation3.gif", "assets/images/backgrounds/wave-anim.gif"];
        if(audioElement.audio.currentTime==0){
            $.post("includes/handlers/ajax/updatePlays.php",{songId: audioElement.currentlyPlayingSong.songID});
        }
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();

        $(".playAnim img").attr("src",playAnimOptions[Math.floor(Math.random()*4)]);

        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        $(".playAnim img").attr("src","assets/images/backgrounds/wave-rest.png");
        audioElement.pause();
    }
    
    
</script>

<style>
    .songArtistInfo {
        width:85%;
    }

</style>

<div id="nowPlayingBarContainer">
            
    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink"><img class="albumArtwork" src="assets/images/square.jpg"></span>

            </div>

        </div>

        <div id="nowPlayingCenter">
            <div class="media-icons">
            </div>
            <div class="content npcenter-top playerControls">
                
                <div class="songArtistInfo">
                    <span class="playAnim"><img class="albumArtwork" src="assets/images/backgrounds/wave-rest.png"></span>

                    <div class="trackInfo">
                        <span class="trackName">
                            <span>Track Title</span>
                        </span>
                        <span class="artistName">
                            <span>Artist name</span>
                        </span>

                    </div>
                
                </div>

                
    
                <div class="buttons">
                    <div class="buttonsAlign">
       
                        <button title="play" class="controlButton play"><img alt="play" src="assets/images/icons/play.png" onclick="playSong()"></button>
                        <button title="pause track" class="controlButton pause" style="display: none;"><img alt="pause" src="assets/images/icons/pause.png"></button>
                
                    </div>
                </div>
                

            </div>

        </div>

        <div id="nowPlayingRight">
            
            <div class="volumeBar">
                <button class="controlButton volume" title="volume">
                    <img alt="volume" src="assets/images/icons/volume.png" onclick="setMute()">                        
                </button>
                <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress">

                            </div>

                        </div>
                </div>
            </div>

        </div>

    </div>

</div>