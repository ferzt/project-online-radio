<?php

class User {
    
    private $con;
    private $mysqlData;
    private $username;
    private $userId;
    private $userPlaylistIds;
    
    public function __construct($con, $username) {
   
        $this->con = $con;
        $this->username = $username;    
        $this->mysqlData = mysqli_query($this->con, "SELECT playlistID, name, public FROM PLAYLIST P, USERS U WHERE P.createdBy = U.userID
        AND U.username='$username'");
        
        $queryId = mysqli_query($this->con, "SELECT userID FROM USERS WHERE username='$username'");
        
        $this->userPlaylistIds = array();
        
        while($row = mysqli_fetch_array($this->mysqlData)){
            
            $playlistId =$row;
            
            array_push($this->userPlaylistIds, $playlistId);
            
        }
        
        while($row = mysqli_fetch_array($queryId)){
            
            $this->userId =$row["userID"];
            
        }
        
    }
    
    
    
    public function getPlaylistIds() {
        
        return $this->userPlaylistIds; 
        
    }
    
    public function getPlaylistSongs(){
        
        $playlistSongs = array();
        
        while($row = mysqli_fetch_array($this->mysqlData)){
            
            $playlistId =$row["playlistID"];
            
            $query = mysqli_query($this->con, "SELECT * FROM PLAYLIST_INCLUSION P, SONG S WHERE P.songInclusion = S.songID AND P.playlistInclusion = $playlistId");
            
            $playlistSongInfo = array();
            while($col = mysqli_fetch_array($query)){
                array_push($playlistSongInfo, $col);
            }
            array_push($playlistSongs, $playlistSongInfo);
        }
        
        return $playlistSongs;
        
    }
    
    public function getFavoriteSongs() {
        
        $playlistSongs = array();
            
        $query = mysqli_query($this->con, "SELECT Rating, lastListen, numberListens, S.title as song_title, mp3File, releaseSong, artwork as album_art, A.title as album_title, albumID, songID FROM HEARING H, SONG S, ALBUM A, ALBUM_INCLUSION AI WHERE H.songHear = S.songID AND AI.songAlbum = H.songHear AND A.albumID = AI.album AND userHear = '$this->userId' AND favorite = true ORDER BY lastListen ASC LIMIT 4");


        while($col = mysqli_fetch_array($query)){

            array_push($playlistSongs, $col);
        }

        
        return $playlistSongs;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function advertiseRecentReleases() {
        $collectionSongs = array();
            
        $query = mysqli_query($this->con, "SELECT S.title as song_title, mp3File, releaseSong, artwork as album_art, A.title as album_title, albumID, songID FROM SONG S, ALBUM A, ALBUM_INCLUSION AI WHERE AI.songAlbum = S.songID AND A.albumID = AI.album ORDER BY releaseSong DESC LIMIT 4");


        while($col = mysqli_fetch_array($query)){

            array_push($collectionSongs, $col);
        }

        
        return $collectionSongs;
    }
    
    public function songInFavorite(){
        //if song in favorite show last listen and rating
    }
    
}

?>